@extends('layouts.app')

@section('title', $seedBatch->batch_code . ' — Forest Nursery')
@section('page-title', $seedBatch->batch_code)
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a5 5 0 0 1 5 5c0 2.76-5 8-5 8s-5-5.24-5-8a5 5 0 0 1 5-5z"/><circle cx="12" cy="7" r="1.5"/></svg>
@endsection

@section('page-actions')
<a href="{{ route('seed-batches.edit', $seedBatch->id) }}" class="btn btn-secondary">
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
                Batch Information
            </div>
            <div class="detail-grid">
                <div class="detail-item">
                    <dt>Batch Code</dt>
                    <dd style="font-family:var(--font-mono);font-weight:600;">{{ $seedBatch->batch_code }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Species</dt>
                    <dd><a href="{{ route('species.show', $seedBatch->species->id) }}" style="color:#0f172a;text-decoration:none;font-weight:500;">{{ $seedBatch->species->name ?? '—' }}</a></dd>
                </div>
                <div class="detail-item">
                    <dt>Origin</dt>
                    <dd>{{ $seedBatch->origin->name ?? '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Source Type</dt>
                    <dd>
                        @if($seedBatch->source_type === 'wild_collected')
                            <span class="badge badge-amber"><span class="badge-dot"></span>Wild Collected</span>
                        @else
                            <span class="badge badge-blue"><span class="badge-dot"></span>Purchased</span>
                        @endif
                    </dd>
                </div>
                <div class="detail-item">
                    <dt>Supplier</dt>
                    <dd>{{ $seedBatch->supplier_name ?? '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Collection Date</dt>
                    <dd>{{ ($seedBatch->collection_date ? date('M d, Y', strtotime($seedBatch->collection_date)) : null) ?? '—' }}</dd>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                Stock & Details
            </div>
            <div class="detail-grid">
                <div class="detail-item" style="grid-column:1/-1;">
                    <dt>Stock Level</dt>
                    <dd>
                        @php
                            $pct = $seedBatch->initial_quantity > 0 ? round(($seedBatch->remaining_quantity / $seedBatch->initial_quantity) * 100) : 0;
                            $fillClass = 'stock-bar-fill-green';
                            if ($pct < 25) $fillClass = 'stock-bar-fill-red';
                            elseif ($pct < 50) $fillClass = 'stock-bar-fill-amber';
                        @endphp
                        <div class="stock-bar" style="max-width:300px;">
                            <div class="stock-bar-track"><div class="stock-bar-fill {{ $fillClass }}" style="width:{{ $pct }}%"></div></div>
                            <div class="stock-bar-text">{{ number_format($seedBatch->remaining_quantity) }} / {{ number_format($seedBatch->initial_quantity) }} {{ $seedBatch->unit }}</div>
                        </div>
                    </dd>
                </div>
                <div class="detail-item">
                    <dt>Storage Location</dt>
                    <dd>{{ $seedBatch->storage_location ?? '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Viability</dt>
                    <dd>{{ $seedBatch->viability_percentage ? number_format($seedBatch->viability_percentage, 1) . '%' : '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Plants Grown</dt>
                    <dd style="font-weight:600;">{{ $seedBatch->plants_count ?? 0 }}</dd>
                </div>
                @if($seedBatch->notes)
                <div class="detail-item" style="grid-column:1/-1;">
                    <dt>Notes</dt>
                    <dd>{{ $seedBatch->notes }}</dd>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($seedBatch->plants && $seedBatch->plants->count() > 0)
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding-bottom:0;">
        <div class="card-title">Plants from this Batch</div>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>UUID</th>
                    <th>Species</th>
                    <th style="text-align:center;">Height</th>
                    <th style="text-align:center;">Health</th>
                    <th style="text-align:center;">Stage</th>
                    <th style="text-align:center;">Sold</th>
                </tr>
            </thead>
            <tbody>
                @foreach($seedBatch->plants as $plant)
                <tr>
                    <td><a href="{{ route('plants.show', $plant->uuid) }}" style="font-family:var(--font-mono);font-size:11.5px;color:#64748b;text-decoration:none;">{{ substr($plant->uuid, 0, 8) }}…</a></td>
                    <td>{{ $plant->species->name ?? '—' }}</td>
                    <td style="text-align:center;font-family:var(--font-mono);">{{ $plant->height_cm }}<span style="color:#94a3b8;margin-left:2px;">cm</span></td>
                    <td style="text-align:center;">
                        @php
                            $hMap = ['healthy'=>'emerald','diseased'=>'red','damaged'=>'amber','dead'=>'gray'];
                            $hColor = $hMap[$plant->health_status] ?? 'gray';
                        @endphp
                        <span class="badge badge-{{ $hColor }}"><span class="badge-dot"></span>{{ $plant->health_status }}</span>
                    </td>
                    <td style="text-align:center;">
                        @php
                            $sMap = ['seedling'=>'blue','juvenile'=>'violet','mature'=>'emerald','ready_for_sale'=>'amber'];
                            $sColor = $sMap[$plant->growth_stage] ?? 'gray';
                        @endphp
                        <span class="badge badge-{{ $sColor }}"><span class="badge-dot"></span>{{ str_replace('_', ' ', $plant->growth_stage) }}</span>
                    </td>
                    <td style="text-align:center;">
                        @if($plant->is_sold)
                            <span class="badge badge-gray">Sold</span>
                        @else
                            <span class="badge badge-emerald"><span class="badge-dot"></span>Available</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<a href="{{ route('seed-batches.index') }}" class="btn btn-secondary">&larr; Back to Seed Batches</a>
@endsection
