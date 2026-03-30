<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class OriginController extends Controller
{
    public function __construct(
        protected ApiClient $api,
    ) {}

    public function index()
    {
        $origins = $this->api->paginate('origins');

        return view('pages.origins.index', compact('origins'));
    }

    public function create()
    {
        return view('pages.origins.create');
    }

    public function store(Request $request)
    {
        $origin = $this->api->submit('post', 'origins', $request->only([
            'name', 'region_code', 'country', 'description',
        ]));

        if ($request->filled('multiplier')) {
            $this->api->submit('put', "origins/{$origin->id}/multiplier", [
                'multiplier' => $request->multiplier,
                'notes' => $request->multiplier_notes,
            ]);
        }

        return redirect()->route('origins.index')->with('success', 'Origin created successfully.');
    }

    public function show(string $id)
    {
        $origin = $this->api->find("origins/{$id}");

        return view('pages.origins.show', compact('origin'));
    }

    public function edit(string $id)
    {
        $origin = $this->api->find("origins/{$id}");

        return view('pages.origins.edit', compact('origin'));
    }

    public function update(Request $request, string $id)
    {
        $this->api->submit('put', "origins/{$id}", $request->only([
            'name', 'region_code', 'country', 'description',
        ]));

        if ($request->filled('multiplier')) {
            $this->api->submit('put', "origins/{$id}/multiplier", [
                'multiplier' => $request->multiplier,
                'notes' => $request->multiplier_notes,
            ]);
        }

        return redirect()->route('origins.index')->with('success', 'Origin updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->api->delete("origins/{$id}");

        return redirect()->route('origins.index')->with('success', 'Origin deleted successfully.');
    }
}
