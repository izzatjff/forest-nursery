<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class SpeciesController extends Controller
{
    public function __construct(
        protected ApiClient $api,
    ) {}

    public function index()
    {
        $species = $this->api->paginate('species');

        return view('pages.species.index', compact('species'));
    }

    public function create()
    {
        return view('pages.species.create');
    }

    public function store(Request $request)
    {
        $this->api->submit('post', 'species', $request->all());

        return redirect()->route('species.index')->with('success', 'Species created successfully.');
    }

    public function show(string $id)
    {
        $species = $this->api->find("species/{$id}");

        // Fetch related seed batches and plants for this species from the API
        $species->seed_batches = $this->api->all('seed-batches', ['species_id' => $id, 'per_page' => 100]);
        $species->plants = $this->api->all('plants', ['species_id' => $id, 'is_sold' => false, 'per_page' => 10]);

        return view('pages.species.show', compact('species'));
    }

    public function edit(string $id)
    {
        $species = $this->api->find("species/{$id}");

        return view('pages.species.edit', compact('species'));
    }

    public function update(Request $request, string $id)
    {
        $this->api->submit('put', "species/{$id}", $request->all());

        return redirect()->route('species.index')->with('success', 'Species updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->api->delete("species/{$id}");

        return redirect()->route('species.index')->with('success', 'Species deleted successfully.');
    }
}
