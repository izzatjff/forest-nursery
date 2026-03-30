<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function __construct(
        protected ApiClient $api,
    ) {}

    public function index()
    {
        $multipliers = $this->api->all('pricing/origin-multipliers');
        $brackets = $this->api->all('pricing/height-brackets');
        $rules = $this->api->paginate('pricing/rules');

        return view('pages.pricing.index', compact('multipliers', 'brackets', 'rules'));
    }

    public function createRule()
    {
        return view('pages.pricing.create-rule');
    }

    public function storeRule(Request $request)
    {
        $this->api->submit('post', 'pricing/rules', $request->all());

        return redirect()->route('pricing.index')->with('success', 'Pricing rule created successfully.');
    }

    public function editRule(string $id)
    {
        $pricingRule = $this->api->find("pricing/rules/{$id}");

        return view('pages.pricing.edit-rule', compact('pricingRule'));
    }

    public function updateRule(Request $request, string $id)
    {
        $this->api->submit('put', "pricing/rules/{$id}", $request->all());

        return redirect()->route('pricing.index')->with('success', 'Pricing rule updated successfully.');
    }

    public function destroyRule(string $id)
    {
        $this->api->delete("pricing/rules/{$id}");

        return redirect()->route('pricing.index')->with('success', 'Pricing rule deleted successfully.');
    }

    public function createMultiplier()
    {
        $origins = $this->api->all('origins', ['per_page' => 100]);

        return view('pages.pricing.create-multiplier', compact('origins'));
    }

    public function storeMultiplier(Request $request)
    {
        $this->api->submit('post', 'pricing/origin-multipliers', $request->only([
            'origin_id', 'multiplier', 'notes',
        ]));

        return redirect()->route('pricing.index')->with('success', 'Origin multiplier saved
 successfully.');
    }

    public function createBracket()
    {
        $species = $this->api->all('species', ['per_page' => 100]);

        return view('pages.pricing.create-bracket', compact('species'));
    }

    public function storeBracket(Request $request)
    {
        $this->api->submit('post', 'pricing/height-brackets', $request->only([
            'species_id', 'min_height_cm', 'max_height_cm', 'multiplier',
        ]));

        return redirect()->route('pricing.index')->with('success', 'Height bracket created successfully.');
    }

    public function destroyBracket(string $id)
    {
        $this->api->delete("pricing/height-brackets/{$id}");

        return redirect()->route('pricing.index')->with('success', 'Height bracket deleted successfully.');
    }

    public function destroyMultiplier(string $id)
    {
        $this->api->delete("pricing/origin-multipliers/{$id}");

        return redirect()->route('pricing.index')->with('success', 'Origin multiplier deleted successfully.');
    }
}
