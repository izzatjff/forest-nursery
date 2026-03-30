<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(
        protected ApiClient $api,
    ) {}

    public function index()
    {
        $sales = $this->api->paginate('sales');

        return view('pages.sales.index', compact('sales'));
    }

    public function create()
    {
        $seedBatches = $this->api->all('seed-batches', ['per_page' => 100, 'in_stock' => true]);
        $plants = $this->api->all('plants', ['per_page' => 100, 'is_sold' => false]);

        return view('pages.sales.create', compact('seedBatches', 'plants'));
    }

    public function store(Request $request)
    {
        $this->api->submit('post', 'sales', $request->all());

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
    }

    public function show(string $id)
    {
        $sale = $this->api->find("sales/{$id}");

        return view('pages.sales.show', compact('sale'));
    }
}
