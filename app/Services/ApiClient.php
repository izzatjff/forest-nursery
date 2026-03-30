<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ApiClient
{
    protected string $baseUrl;

    protected string $hostHeader;

    protected int $timeout;

    public function __construct()
    {
        $configuredUrl = rtrim(config('services.nursery_api.base_url', 'http://forest-nursery-api.test'), '/');
        $internalUrl = config('services.nursery_api.internal_url');

        // In Docker, the .test domain resolves to 127.0.0.1 (the container itself),
        // so we route through the nginx service name and pass the correct Host header.
        if ($internalUrl) {
            $parsed = parse_url($configuredUrl);
            $this->hostHeader = $parsed['host'] ?? 'forest-nursery-api.test';
            $this->baseUrl = rtrim($internalUrl, '/').'/api';
        } else {
            $this->hostHeader = '';
            $this->baseUrl = $configuredUrl.'/api';
        }

        $this->timeout = (int) config('services.nursery_api.timeout', 15);
    }

    /**
     * Perform a GET request to the API.
     * Returns raw decoded JSON (arrays, not objects) so Blade views
     * can use array syntax like $stats['key'] and $alert['species'].
     */
    public function get(string $endpoint, array $query = []): mixed
    {
        $response = $this->request('get', $endpoint, $query);
        $body = $response->json();

        // Unwrap { "data": ... } envelope if present
        if (is_array($body) && array_key_exists('data', $body) && count($body) <= 3) {
            return $body['data'];
        }

        return $body;
    }

    /**
     * Perform a POST request to the API.
     *
     * @return array|object
     */
    public function post(string $endpoint, array $data = []): mixed
    {
        $response = $this->request('post', $endpoint, $data);

        return $this->decodeResponse($response);
    }

    /**
     * Perform a PUT request to the API.
     *
     * @return array|object
     */
    public function put(string $endpoint, array $data = []): mixed
    {
        $response = $this->request('put', $endpoint, $data);

        return $this->decodeResponse($response);
    }

    /**
     * Perform a DELETE request to the API.
     *
     * @return array|object
     */
    public function delete(string $endpoint): mixed
    {
        $response = $this->request('delete', $endpoint);

        return $this->decodeResponse($response);
    }

    /**
     * Fetch a paginated resource from the API and return a LengthAwarePaginator
     * that Blade views can call ->links() on.
     */
    public function paginate(string $endpoint, array $query = [], int $perPage = 15): LengthAwarePaginator
    {
        $query['per_page'] = $query['per_page'] ?? $perPage;
        $query['page'] = $query['page'] ?? request()->input('page', 1);

        $response = $this->request('get', $endpoint, $query);
        $body = $response->json();

        // Laravel API Resource collections wrap data in { data: [], links: {}, meta: {} }
        // Raw paginate() calls return { data: [], current_page: ..., total: ... }
        $items = $body['data'] ?? [];
        $meta = $body['meta'] ?? $body;

        $currentPage = (int) ($meta['current_page'] ?? 1);
        $total = (int) ($meta['total'] ?? count($items));
        $perPageActual = (int) ($meta['per_page'] ?? $perPage);

        // Convert each item to an object so Blade views can use -> syntax
        $objectItems = array_map(fn ($item) => $this->arrayToObject($item), $items);

        return new LengthAwarePaginator(
            $objectItems,
            $total,
            $perPageActual,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    /**
     * Fetch a single resource and return it as an object (so Blade -> syntax works).
     */
    public function find(string $endpoint): object
    {
        $response = $this->request('get', $endpoint);
        $body = $response->json();

        // API resources return { data: { ... } }
        $data = $body['data'] ?? $body;

        return $this->arrayToObject($data);
    }

    /**
     * Fetch a list of all items (non-paginated) and return as a Collection
     * of objects. Blade views can call ->isEmpty(), ->count(), and use
     * arrow syntax on each item (e.g. $species->name).
     */
    public function all(string $endpoint, array $query = []): Collection
    {
        $response = $this->request('get', $endpoint, $query);
        $body = $response->json();

        $items = $body['data'] ?? $body;

        if (! is_array($items)) {
            return collect();
        }

        return collect($items)->map(fn ($item) => is_array($item) ? $this->arrayToObject($item) : $item);
    }

    /**
     * Submit data to the API (create/update) with validation error handling.
     * If the API returns 422, throws a ValidationException that Laravel's
     * redirect()->back()->withErrors() understands.
     *
     * @return object The created/updated resource
     */
    public function submit(string $method, string $endpoint, array $data = []): object
    {
        try {
            $response = $this->request($method, $endpoint, $data);
            $body = $response->json();

            $resource = $body['data'] ?? $body;

            return is_array($resource) ? $this->arrayToObject($resource) : (object) $resource;
        } catch (RequestException $e) {
            if ($e->response->status() === 422) {
                $errors = $e->response->json('errors', []);
                $message = $e->response->json('message', 'Validation failed.');

                throw ValidationException::withMessages($errors)->errorBag('default');
            }

            throw $e;
        }
    }

    /**
     * Send the HTTP request to the API.
     *
     * @throws RequestException
     */
    protected function request(string $method, string $endpoint, array $data = []): Response
    {
        $url = $this->baseUrl.'/'.ltrim($endpoint, '/');

        $headers = [
            'X-Requested-With' => 'XMLHttpRequest',
        ];

        // When running inside Docker, send the Host header so nginx
        // routes the request to the correct server block.
        if ($this->hostHeader !== '') {
            $headers['Host'] = $this->hostHeader;
        }

        $pending = Http::timeout($this->timeout)
            ->acceptJson()
            ->withHeaders($headers);

        try {
            $response = match (strtolower($method)) {
                'get' => $pending->get($url, $data),
                'post' => $pending->post($url, $data),
                'put' => $pending->put($url, $data),
                'patch' => $pending->patch($url, $data),
                'delete' => $pending->delete($url),
                default => throw new \InvalidArgumentException("Unsupported HTTP method: {$method}"),
            };

            // Throw on 4xx/5xx responses (except 422 which we handle in submit())
            if ($response->failed() && $response->status() !== 422) {
                Log::error('API request failed', [
                    'method' => $method,
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                $response->throw();
            }

            // For 422, still throw so submit() can catch it
            if ($response->status() === 422) {
                $response->throw();
            }

            return $response;
        } catch (RequestException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('API connection error', [
                'method' => $method,
                'url' => $url,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Decode a response body, returning the data portion as an object or array.
     */
    protected function decodeResponse(Response $response): mixed
    {
        $body = $response->json();

        if (is_array($body) && array_key_exists('data', $body)) {
            $data = $body['data'];

            if (is_array($data) && ! $this->isAssociative($data)) {
                return array_map(fn ($item) => is_array($item) ? $this->arrayToObject($item) : $item, $data);
            }

            return is_array($data) ? $this->arrayToObject($data) : $data;
        }

        return $body;
    }

    /**
     * Recursively convert a nested associative array to a stdClass object tree.
     * This allows Blade views to use -> arrow syntax (e.g. $species->name)
     * on data fetched from the API.
     */
    protected function arrayToObject(array $array): object
    {
        $obj = new \stdClass;

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if ($this->isAssociative($value)) {
                    // Nested associative array → nested object
                    $obj->{$key} = $this->arrayToObject($value);
                } else {
                    // Sequential array → Collection of objects/values
                    // so Blade views can call ->isEmpty(), ->count(), etc.
                    $obj->{$key} = collect(array_map(function ($item) {
                        return is_array($item) && $this->isAssociative($item)
                            ? $this->arrayToObject($item)
                            : $item;
                    }, $value));
                }
            } else {
                $obj->{$key} = $value;
            }
        }

        return $obj;
    }

    /**
     * Check if an array is associative (string keys) vs sequential (numeric keys).
     */
    protected function isAssociative(array $array): bool
    {
        if (empty($array)) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }
}
