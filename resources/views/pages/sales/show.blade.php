@extends('layouts.app')

@section('title', $sale->sale_number . ' — Forest Nursery')
@section('page-title', $sale->sale_number)
@section('page-icon')
    <svg class="topbar-title-icon" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
      <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
      <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
    </svg>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                Sale Information
            </div>
            <div class="detail-grid">
                <div class="detail-item">
                    <dt>Invoice Number</dt>
                    <dd style="font-family:var(--font-mono);font-weight:600;">{{ $sale->sale_number }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Date</dt>
                    <dd>{{ ($sale->sold_at ? date('M d, Y H:i', strtotime($sale->sold_at)) : null) ?? '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Customer</dt>
                    <dd>{{ $sale->customer_name ?: 'Walk-in' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Contact</dt>
                    <dd>{{ $sale->customer_contact ?? '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Payment Method</dt>
                    <dd>
                        @if($sale->payment_method)
                            <span class="badge badge-blue"><span class="badge-dot"></span>{{ ucfirst($sale->payment_method) }}</span>
                        @else
                            —
                        @endif
                    </dd>
                </div>
                <div class="detail-item">
                    <dt>Seller</dt>
                    <dd>{{ $sale->seller->name ?? '—' }}</dd>
                </div>
                @if($sale->notes)
                <div class="detail-item" style="grid-column:1/-1;">
                    <dt>Notes</dt>
                    <dd>{{ $sale->notes }}</dd>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Financial Summary
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--color-border-light);">
                    <span style="color:#64748b;">Subtotal</span>
                    <span style="font-family:var(--font-mono);font-weight:500;">RM{{ number_format($sale->subtotal, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--color-border-light);">
                    <span style="color:#64748b;">Tax</span>
                    <span style="font-family:var(--font-mono);font-weight:500;">RM{{ number_format($sale->tax_amount, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:12px 0;border-top:2px solid #0f172a;">
                    <span style="font-weight:700;font-size:15px;">Total</span>
                    <span style="font-family:var(--font-mono);font-weight:700;font-size:18px;color:#16a34a;">RM{{ number_format($sale->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@if($sale->items && $sale->items->count() > 0)
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding-bottom:0;">
        <div class="card-title">Sale Items</div>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Item</th>
                    <th style="text-align:center;">Quantity</th>
                    <th style="text-align:right;">Unit Price</th>
                    <th style="text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr>
                    <td>
                        @if($item->item_type === 'seed_batch')
                            <span class="badge badge-amber"><span class="badge-dot"></span>Seeds</span>
                        @else
                            <span class="badge badge-blue"><span class="badge-dot"></span>Plant</span>
                        @endif
                    </td>
                    <td style="font-weight:500;">
                        @if($item->item_type === 'seed_batch' && $item->seed_batch)
                            {{ $item->seed_batch->species->name ?? $item->seed_batch->batch_code }}
                        @elseif($item->plant)
                            {{ $item->plant->species->name ?? substr($item->plant->uuid, 0, 8) }}
                        @else
                            —
                        @endif
                    </td>
                    <td style="text-align:center;font-family:var(--font-mono);">{{ number_format($item->quantity, 2) }}</td>
                    <td style="text-align:right;font-family:var(--font-mono);">RM{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align:right;font-family:var(--font-mono);font-weight:600;">RM{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<a href="{{ route('sales.index') }}" class="btn btn-secondary">&larr; Back to Sales</a>
@endsection
