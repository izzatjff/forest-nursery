@extends('layouts.app')

@section('title', 'Procurements — Forest Nursery')
@section('page-title', 'Procurements')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
@endsection

@section('page-actions')
<a href="{{ route('procurements.create') }}" class="btn btn-primary">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Procurement
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            All Procurements
        </div>
    </div>

    @if($procurements->isEmpty())
        <div style="padding:24px;">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                </div>
                <div class="empty-state-title">No procurements</div>
                <div class="empty-state-text">Record your first seed procurement</div>
            </div>
        </div>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Supplier</th>
                        <th>Species</th>
                        <th>Origin</th>
                        <th style="text-align:center;">Quantity</th>
                        <th style="text-align:right;">Total Cost</th>
                        <th>Received</th>
                        <th>Batch</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($procurements as $proc)
                    <tr>
                        <td>
                            <a href="{{ route('procurements.show', $proc->id) }}" style="font-family:var(--font-mono);font-size:12px;font-weight:600;color:#0f172a;text-decoration:none;">{{ $proc->procurement_number }}</a>
                        </td>
                        <td style="font-weight:500;">{{ $proc->supplier_name }}</td>
                        <td>{{ $proc->species->name ?? '—' }}</td>
                        <td style="color:#64748b;">{{ $proc->origin->name ?? '—' }}</td>
                        <td style="text-align:center;font-family:var(--font-mono);">{{ number_format($proc->quantity) }} {{ $proc->unit ?? '' }}</td>
                        <td style="text-align:right;font-family:var(--font-mono);font-weight:600;">RM{{ number_format($proc->total_cost, 2) }}</td>
                        <td style="color:#64748b;font-size:12.5px;">{{ ($proc->received_date ? date('M d, Y', strtotime($proc->received_date)) : null) ?? '—' }}</td>
                        <td>
                            @if($proc->seed_batch)
                                <a href="{{ route('seed-batches.show', $proc->seed_batch->id) }}" style="font-family:var(--font-mono);font-size:11px;color:#64748b;text-decoration:none;">{{ $proc->seed_batch->batch_code }}</a>
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;">
            {{ $procurements->links() }}
        </div>
    @endif
</div>
@endsection
