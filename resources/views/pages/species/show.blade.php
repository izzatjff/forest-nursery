@extends('layouts.app')

@section('title', $species->name . ' — Forest Nursery')
@section('page-title', $species->name)
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L3 7l9 5 9-5-9-5z"/><path d="M3 17l9 5 9-5"/><path d="M3 12l9 5 9-5"/></svg>
@endsection

@section('page-actions')
<a href="{{ route('species.edit', $species->id) }}" class="btn btn-secondary">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
    Edit
</a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                Species Information
            </div>
            <div class="detail-grid">
                <div class="detail-item">
                    <dt>Common Name</dt>
                    <dd>{{ $species->name }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Scientific Name</dt>
                    <dd style="font-style:italic;">{{ $species->scientific_name }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Base Price</dt>
                    <dd style="font-family:var(--font-mono);color:#16a34a;font-weight:600;">RM{{ number_format($species->base_price, 2) }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Low Stock Threshold</dt>
                    <dd>{{ $species->low_stock_threshold }}</dd>
                </div>
                @if($species->description)
                <div class="detail-item" style="grid-column:1/-1;">
                    <dt>Description</dt>
                    <dd>{{ $species->description }}</dd>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                Statistics
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="stat-card stat-card-emerald" style="padding:16px;">
                    <div class="stat-card-label">Seed Batches</div>
                    <div class="stat-card-value" style="font-size:28px;">{{ $species->seed_batches_count ?? 0 }}</div>
                </div>
                <div class="stat-card stat-card-blue" style="padding:16px;">
                    <div class="stat-card-label">Plants</div>
                    <div class="stat-card-value" style="font-size:28px;">{{ $species->plants_count ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($species->seed_batches && $species->seed_batches->count() > 0)
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding-bottom:0;">
        <div class="card-title">Seed Batches</div>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Batch Code</th>
                    <th>Origin</th>
                    <th>Remaining</th>
                    <th>Source</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($species->seed_batches as $batch)
                <tr>
                    <td><a href="{{ route('seed-batches.show', $batch->id) }}" style="font-family:var(--font-mono);font-size:12px;font-weight:600;color:#0f172a;text-decoration:none;">{{ $batch->batch_code }}</a></td>
                    <td>{{ $batch->origin->name ?? '—' }}</td>
                    <td>{{ number_format($batch->remaining_quantity) }} / {{ number_format($batch->initial_quantity) }}</td>
                    <td>
                        @if($batch->source_type === 'wild_collected')
                            <span class="badge badge-amber"><span class="badge-dot"></span>Wild</span>
                        @else
                            <span class="badge badge-blue"><span class="badge-dot"></span>Purchased</span>
                        @endif
                    </td>
                    <td style="color:#64748b;font-size:12.5px;">{{ ($batch->collection_date ? date('M d, Y', strtotime($batch->collection_date)) : null) ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<a href="{{ route('species.index') }}" class="btn btn-secondary">&larr; Back to Species</a>
@endsection
