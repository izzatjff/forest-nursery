<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class SeedBatchController extends Controller
{
    public function __construct(
        protected ApiClient $api,
    ) {}

    public function index()
    {
        $batches = $this->api->paginate('seed-batches');

        return view('pages.seed-batches.index', compact('batches'));
    }

    public function create()
    {
        $species = $this->api->all('species', ['per_page' => 100]);
        $origins = $this->api->all('origins', ['per_page' => 100]);

        return view('pages.seed-batches.create', compact('species', 'origins'));
    }

    public function store(Request $request)
    {
        $this->api->submit('post', 'seed-batches', $request->all());

        return redirect()->route('seed-batches.index')->with('success', 'Seed batch created successfully.');
    }

    public function show(string $id)
    {
        $seedBatch = $this->api->find("seed-batches/{$id}");

        $seedBatch->plants = $this->api->all('plants', ['seed_batch_id' => $id, 'per_page' => 100]);

        return view('pages.seed-batches.show', compact('seedBatch'));
    }

    public function edit(string $id)
    {
        $seedBatch = $this->api->find("seed-batches/{$id}");
        $species = $this->api->all('species', ['per_page' => 100]);
        $origins = $this->api->all('origins', ['per_page' => 100]);

        return view('pages.seed-batches.edit', compact('seedBatch', 'species', 'origins'));
    }

    public function update(Request $request, string $id)
    {
        $this->api->submit('put', "seed-batches/{$id}", $request->all());

        return redirect()->route('seed-batches.index')->with('success', 'Seed batch updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->api->delete("seed-batches/{$id}");

        return redirect()->route('seed-batches.index')->with('success', 'Seed batch deleted successfully.');
    }
}
