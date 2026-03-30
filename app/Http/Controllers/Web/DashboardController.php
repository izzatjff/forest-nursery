<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;

class DashboardController extends Controller
{
    public function __construct(
        protected ApiClient $api,
    ) {}

    public function index()
    {
        $stats = $this->api->get('dashboard/stats');
        $lowStock = $this->api->get('dashboard/low-stock');
        $recentSales = $this->api->all('dashboard/recent-sales');

        return view('pages.dashboard', compact('stats', 'lowStock', 'recentSales'));
    }
}
