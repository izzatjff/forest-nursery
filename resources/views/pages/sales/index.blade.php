@extends('layouts.app')

@section('title', 'Sales — Forest Nursery')
@section('page-title', 'Sales History')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
@endsection

@section('page-actions')
<a href="{{ route('sales.create') }}" class="btn btn-primary">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Sale
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
            All Sales
        </div>
    </div>

    @if($sales->isEmpty())
        <div style="padding:24px;">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                </div>
                <div class="empty-state-title">No sales recorded</div>
                <div class="empty-state-text">Process a sale to see it here</div>
            </div>
        </div>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th style="text-align:center;">Items</th>
                        <th style="text-align:right;">Total</th>
                        <th style="text-align:center;">Payment</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr class="hover:cursor-pointer" onclick="window.location.href='{{ route('sales.show', $sale->id) }}';">
                        <td style="font-family:var(--font-mono);font-size:12px;font-weight:600;color:#0f172a;text-decoration:none;">
                            {{ $sale->sale_number }}
                        </td>
                        <td style="font-weight:500;">{{ $sale->customer_name ?: 'Walk-in' }}</td>
                        <td style="text-align:center;">
                            <span class="badge badge-gray">{{ $sale->items->count() }} item{{ $sale->items->count() !== 1 ? 's' : '' }}</span>
                        </td>
                        <td style="text-align:right;font-family:var(--font-mono);font-weight:700;color:#16a34a;">RM{{ number_format($sale->total_amount, 2) }}</td>
                        <td style="text-align:center;">
                            @if($sale->payment_method)
                                <span class="badge badge-blue"><span class="badge-dot"></span>{{ ucfirst($sale->payment_method) }}</span>
                            @else
                                <span style="color:#94a3b8;">—</span>
                            @endif
                        </td>
                        <td style="color:#64748b;font-size:12.5px;">{{ ($sale->sold_at ? date('M d, Y', strtotime($sale->sold_at)) : null) ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;">
            {{ $sales->links() }}
        </div>
    @endif
</div>
@endsection
