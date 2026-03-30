@extends('layouts.app')

@section('title', 'Dashboard — Forest Nursery')
@section('page-title', 'Dashboard')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
@endsection

@section('content')
<!-- Stat Cards -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:28px;">
    <div class="stat-card stat-card-emerald">
        <div class="stat-card-top">
            <div class="stat-card-label">Seeds in Stock</div>
            <div class="stat-card-icon-wrap stat-icon-emerald">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a5 5 0 0 1 5 5c0 2.76-5 8-5 8s-5-5.24-5-8a5 5 0 0 1 5-5z"/><circle cx="12" cy="7" r="1.5"/></svg>
            </div>
        </div>
        <div class="stat-card-value">{{ number_format($stats['total_seeds_in_stock'] ?? 0) }}</div>
        <div class="stat-card-sub">{{ $stats['total_seed_batches'] ?? 0 }} active batch{{ ($stats['total_seed_batches'] ?? 0) !== 1 ? 'es' : '' }}</div>
    </div>

    <div class="stat-card stat-card-blue">
        <div class="stat-card-top">
            <div class="stat-card-label">Plants Available</div>
            <div class="stat-card-icon-wrap stat-icon-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>
            </div>
        </div>
        <div class="stat-card-value">{{ number_format($stats['total_plants'] ?? 0) }}</div>
        <div class="stat-card-sub">{{ $stats['total_plants_sold'] ?? 0 }} sold total</div>
    </div>

    <div class="stat-card stat-card-violet">
        <div class="stat-card-top">
            <div class="stat-card-label">Sales This Month</div>
            <div class="stat-card-icon-wrap stat-icon-violet">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
            </div>
        </div>
        <div class="stat-card-value">{{ number_format($stats['sales_this_month'] ?? 0) }}</div>
        <div class="stat-card-sub">{{ $stats['total_sales'] ?? 0 }} all-time</div>
    </div>

    <div class="stat-card stat-card-amber">
        <div class="stat-card-top">
            <div class="stat-card-label">Revenue (Month)</div>
            <div class="stat-card-icon-wrap stat-icon-amber">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
        </div>
        <div class="stat-card-value">RM{{ number_format($stats['revenue_this_month'] ?? 0, 2) }}</div>
        <div class="stat-card-sub">RM{{ number_format($stats['total_revenue'] ?? 0, 2) }} all-time</div>
    </div>
</div>

<!-- Two-column: Alerts + Recent Sales -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(360px,1fr));gap:20px;">

    <!-- Low Stock Alerts -->
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Low Stock Alerts
            </div>

            @if(count($lowStock) === 0)
                <div class="all-good">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    All stock levels are healthy
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($lowStock as $alert)
                        <div class="alert-row alert-row-warning">
                            <div class="alert-row-left">
                                <div class="alert-row-icon alert-icon-warning">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                </div>
                                <div>
                                    <div class="alert-row-text">{{ $alert['species'] ?? 'Unknown' }}@if(!empty($alert['batch_code'])) <span style="color:#94a3b8;font-weight:400;">&middot; {{ $alert['batch_code'] }}</span>@endif</div>
                                    <div class="alert-row-sub">{{ ($alert['type'] ?? '') === 'seed_batch' ? 'Seed Batch' : 'Plant stock' }}</div>
                                </div>
                            </div>
                            <div class="alert-row-right" style="color:#d97706;">{{ isset($alert['remaining']) ? $alert['remaining'] . ' left' : ($alert['message'] ?? '') }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Sales -->
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Recent Sales
            </div>

            @if($recentSales->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                    </div>
                    <div class="empty-state-title">No sales yet</div>
                    <div class="empty-state-text">Sales will appear here once recorded</div>
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($recentSales as $sale)
                        <a href="{{ route('sales.show', $sale->id) }}" class="alert-row alert-row-sale" style="text-decoration:none;">
                            <div class="alert-row-left">
                                <div class="alert-row-icon alert-icon-sale">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                </div>
                                <div>
                                    <div class="alert-row-text">{{ $sale->sale_number }}</div>
                                    <div class="alert-row-sub">{{ $sale->customer_name ?: 'Walk-in customer' }}</div>
                                </div>
                            </div>
                            <div class="alert-row-right" style="color:#16a34a;">${{ number_format($sale->total_amount, 2) }}</div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
