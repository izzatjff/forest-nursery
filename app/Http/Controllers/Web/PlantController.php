<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function __construct(
        protected ApiClient $api,
    ) {}

    public function index()
    {
        $plants = $this->api->paginate('plants');

        return view('pages.plants.index', compact('plants'));
    }

    public function create()
    {
        $species = $this->api->all('species', ['per_page' => 100]);
        $origins = $this->api->all('origins', ['per_page' => 100]);
        $seedBatches = $this->api->all('seed-batches', ['per_page' => 100, 'in_stock' => true]);

        return view('pages.plants.create', compact('species', 'origins', 'seedBatches'));
    }

    public function store(Request $request)
    {
        $this->api->submit('post', 'plants', $request->all());

        return redirect()->route('plants.index')->with('success', 'Plant created successfully.');
    }

    public function show(string $id)
    {
        $plant = $this->api->find("plants/{$id}");

        return view('pages.plants.show', compact('plant'));
    }

    public function edit(string $id)
    {
        $plant = $this->api->find("plants/{$id}");
        $species = $this->api->all('species', ['per_page' => 100]);
        $origins = $this->api->all('origins', ['per_page' => 100]);
        $seedBatches = $this->api->all('seed-batches', ['per_page' => 100]);

        return view('pages.plants.edit', compact('plant', 'species', 'origins', 'seedBatches'));
    }

    public function update(Request $request, string $id)
    {
        $this->api->submit('put', "plants/{$id}", $request->all());

        return redirect()->route('plants.index')->with('success', 'Plant updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->api->delete("plants/{$id}");

        return redirect()->route('plants.index')->with('success', 'Plant deleted successfully.');
    }
}
