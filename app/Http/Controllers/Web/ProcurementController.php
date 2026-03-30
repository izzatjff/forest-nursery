<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class ProcurementController extends Controller
{
    public function __construct(
        protected ApiClient $api,
    ) {}

    public function index()
    {
        $procurements = $this->api->paginate('procurements');

        return view('pages.procurements.index', compact('procurements'));
    }

    public function create()
    {
        $species = $this->api->all('species', ['per_page' => 100]);
        $origins = $this->api->all('origins', ['per_page' => 100]);

        return view('pages.procurements.create', compact('species', 'origins'));
    }

    public function store(Request $request)
    {
        $this->api->submit('post', 'procurements', $request->except('_token'));

        return redirect()->route('procurements.index')->with('success', 'Procurement recorded successfully. Seed batch created.');
    }

    public function show(string $id)
    {
        $procurement = $this->api->find("procurements/{$id}");

        return view('pages.procurements.show', compact('procurement'));
    }
}
