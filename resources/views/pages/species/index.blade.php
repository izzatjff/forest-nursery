@extends('layouts.app')

@section('title', 'Species Catalog — Forest Nursery')
@section('page-title', 'Species Catalog')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L3 7l9 5 9-5-9-5z"/><path d="M3 17l9 5 9-5"/><path d="M3 12l9 5 9-5"/></svg>
@endsection

@section('page-actions')
<a href="{{ route('species.create') }}" class="btn btn-primary">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Species
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L3 7l9 5 9-5-9-5z"/><path d="M3 17l9 5 9-5"/><path d="M3 12l9 5 9-5"/></svg>
            All Species
        </div>
    </div>

    @if($species->isEmpty())
        <div style="padding:24px;">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16.5 9.4 7.55 4.24"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                </div>
                <div class="empty-state-title">No species</div>
                <div class="empty-state-text">Add species to start managing inventory</div>
            </div>
        </div>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Scientific Name</th>
                        <th style="text-align:right;">Base Price</th>
                        <th style="text-align:center;">Batches</th>
                        <th style="text-align:center;">Plants</th>
                        <th style="text-align:center;">Low Threshold</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($species as $sp)
                    <tr class="hover:cursor-pointer" onclick="window.location.href='{{ route('species.show', $sp->id) }}';">
                        <td class="font-bold">
                            {{ $sp->name }}
                        </td>
                        <td style="font-style:italic;color:#64748b;font-size:12.5px;">{{ $sp->scientific_name }}</td>
                        <td style="text-align:right;font-family:var(--font-mono);font-weight:600;color:#16a34a;">RM{{ number_format($sp->base_price, 2) }}</td>
                        <td style="text-align:center;">{{ $sp->seed_batches_count ?? 0 }}</td>
                        <td style="text-align:center;">{{ $sp->plants_count ?? 0 }}</td>
                        <td style="text-align:center;color:#64748b;">{{ $sp->low_stock_threshold }}</td>
                        <td style="text-align:center;">
                            <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                <a href="{{ route('species.edit', $sp->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger-outline" onclick="event.stopPropagation(); confirmDelete('{{ route('species.destroy', $sp->id) }}', '{{ addslashes($sp->name) }}')">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;">
            {{ $species->links() }}
        </div>
    @endif
</div>

@include('partials.delete-modal')
@endsection
