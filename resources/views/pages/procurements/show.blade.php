@extends('layouts.app')

@section('title', $procurement->procurement_number . ' — Forest Nursery')
@section('page-title', $procurement->procurement_number)
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                Procurement Information
            </div>
            <div class="detail-grid">
                <div class="detail-item">
                    <dt>PO Number</dt>
                    <dd style="font-family:var(--font-mono);font-weight:600;">{{ $procurement->procurement_number }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Received Date</dt>
                    <dd>{{ ($procurement->received_date ? date('M d, Y', strtotime($procurement->received_date)) : null) ?? '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Supplier</dt>
                    <dd style="font-weight:500;">{{ $procurement->supplier_name }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Contact</dt>
                    <dd>{{ $procurement->supplier_contact ?? '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Species</dt>
                    <dd><a href="{{ route('species.show', $procurement->species->id) }}" style="color:#0f172a;text-decoration:none;font-weight:500;">{{ $procurement->species->name ?? '—' }}</a></dd>
                </div>
                <div class="detail-item">
                    <dt>Origin</dt>
                    <dd>{{ $procurement->origin->name ?? '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Source Type</dt>
                    <dd>
                        @if($procurement->source_type === 'wild_collected')
                            <span class="badge badge-amber"><span class="badge-dot"></span>Wild Collected</span>
                        @elseif($procurement->source_type === 'donated')
                            <span class="badge badge-violet"><span class="badge-dot"></span>Donated</span>
                        @else
                            <span class="badge badge-blue"><span class="badge-dot"></span>Purchased</span>
                        @endif
                    </dd>
                </div>
                <div class="detail-item">
                    <dt>Linked Batch</dt>
                    <dd>
                        @if($procurement->seed_batch)
                            <a href="{{ route('seed-batches.show', $procurement->seed_batch->id) }}" style="font-family:var(--font-mono);font-size:12px;color:#0f172a;text-decoration:none;">{{ $procurement->seed_batch->batch_code }}</a>
                        @else
                            —
                        @endif
                    </dd>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Financial Details
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--color-border-light);">
                    <span style="color:#64748b;">Quantity</span>
                    <span style="font-family:var(--font-mono);font-weight:500;">{{ number_format($procurement->quantity) }} {{ $procurement->unit ?? 'pieces' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--color-border-light);">
                    <span style="color:#64748b;">Cost per Unit</span>
                    <span style="font-family:var(--font-mono);font-weight:500;">RM{{ number_format($procurement->cost_per_unit, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:12px 0;border-top:2px solid #0f172a;">
                    <span style="font-weight:700;font-size:15px;">Total Cost</span>
                    <span style="font-family:var(--font-mono);font-weight:700;font-size:18px;color:#ef4444;">RM{{ number_format($procurement->total_cost, 2) }}</span>
                </div>
            </div>
            @if($procurement->notes)
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--color-border-light);">
                <dt style="font-size:11px;text-transform:uppercase;letter-spacing:0.05em;color:#94a3b8;margin-bottom:4px;">Notes</dt>
                <dd style="font-size:13px;color:#475569;">{{ $procurement->notes }}</dd>
            </div>
            @endif
        </div>
    </div>
</div>

<a href="{{ route('procurements.index') }}" class="btn btn-secondary">&larr; Back to Procurements</a>
@endsection
