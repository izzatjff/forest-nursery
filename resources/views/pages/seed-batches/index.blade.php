@extends('layouts.app')

@section('title', 'Seed Batches — Forest Nursery')
@section('page-title', 'Seed Batches')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a5 5 0 0 1 5 5c0 2.76-5 8-5 8s-5-5.24-5-8a5 5 0 0 1 5-5z"/><circle cx="12" cy="7" r="1.5"/></svg>
@endsection

@section('page-actions')
<a href="{{ route('seed-batches.create') }}" class="btn btn-primary">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Batch
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a5 5 0 0 1 5 5c0 2.76-5 8-5 8s-5-5.24-5-8a5 5 0 0 1 5-5z"/><circle cx="12" cy="7" r="1.5"/></svg>
            All Seed Batches
        </div>
    </div>

    @if($batches->isEmpty())
        <div style="padding:24px;">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a5 5 0 0 1 5 5c0 2.76-5 8-5 8s-5-5.24-5-8a5 5 0 0 1 5-5z"/><circle cx="12" cy="7" r="1.5"/></svg>
                </div>
                <div class="empty-state-title">No seed batches</div>
                <div class="empty-state-text">Procure seeds to create your first batch</div>
            </div>
        </div>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Batch Code</th>
                        <th>Species</th>
                        <th>Origin</th>
                        <th style="min-width:180px;">Stock</th>
                        <th style="text-align:center;">Source</th>
                        <th style="text-align:center;">Plants</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($batches as $batch)
                    <tr>
                        <td>
                            <a href="{{ route('seed-batches.show', $batch->id) }}" style="font-family:var(--font-mono);font-size:12px;font-weight:600;color:#0f172a;text-decoration:none;">{{ $batch->batch_code }}</a>
                        </td>
                        <td style="font-weight:500;">{{ $batch->species->name ?? '—' }}</td>
                        <td style="color:#64748b;">{{ $batch->origin->name ?? '—' }}</td>
                        <td>
                            @php
                                $pct = $batch->initial_quantity > 0 ? round(($batch->remaining_quantity / $batch->initial_quantity) * 100) : 0;
                                $fillClass = 'stock-bar-fill-green';
                                if ($pct < 25) $fillClass = 'stock-bar-fill-red';
                                elseif ($pct < 50) $fillClass = 'stock-bar-fill-amber';
                            @endphp
                            <div class="stock-bar">
                                <div class="stock-bar-track"><div class="stock-bar-fill {{ $fillClass }}" style="width:{{ $pct }}%"></div></div>
                                <div class="stock-bar-text">{{ number_format($batch->remaining_quantity) }} / {{ number_format($batch->initial_quantity) }}</div>
                            </div>
                        </td>
                        <td style="text-align:center;">
                            @if($batch->source_type === 'wild_collected')
                                <span class="badge badge-amber"><span class="badge-dot"></span>Wild</span>
                            @else
                                <span class="badge badge-blue"><span class="badge-dot"></span>Purchased</span>
                            @endif
                        </td>
                        <td style="text-align:center;">{{ $batch->plants_count ?? 0 }}</td>
                        <td style="text-align:center;">
                            <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                <a href="{{ route('seed-batches.edit', $batch->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger-outline" onclick="confirmDelete('{{ route('seed-batches.destroy', $batch->id) }}', '{{ $batch->batch_code }}')">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;">
            {{ $batches->links() }}
        </div>
    @endif
</div>

@include('partials.delete-modal')
@endsection
