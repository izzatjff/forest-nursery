@extends('layouts.app')

@section('title', 'Origins — Forest Nursery')
@section('page-title', 'Origins')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
@endsection

@section('page-actions')
<a href="{{ route('origins.create') }}" class="btn btn-primary">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Origin
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            All Origins
        </div>
    </div>

    @if($origins->isEmpty())
        <div style="padding:24px;">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
                <div class="empty-state-title">No origins</div>
                <div class="empty-state-text">Add geographic origins for seed sourcing</div>
            </div>
        </div>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Region Code</th>
                        <th>Country</th>
                        <th style="text-align:center;">Price Multiplier</th>
                        <th style="text-align:center;">Batches</th>
                        <th style="text-align:center;">Plants</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($origins as $origin)
                    <tr class="hover:cursor-pointer" onclick="window.location.href='{{ route('origins.show', $origin->id) }}';">
                        <td style="font-weight:600;color:#0f172a; text-decoration: none;" >
                            {{ $origin->name }}
                        </td>
                        <td><span class="badge badge-gray">{{ $origin->region_code }}</span></td>
                        <td style="color:#64748b;">{{ $origin->country ?? '—' }}</td>
                        <td style="text-align:center;">
                            @if($origin->price_multiplier)
                                <span style="font-family:var(--font-mono);font-weight:600;color:#16a34a;">{{ number_format($origin->price_multiplier->multiplier, 2) }}&times;</span>
                            @else
                                <span style="color:#94a3b8;">1.00&times;</span>
                            @endif
                        </td>
                        <td style="text-align:center;">{{ $origin->seed_batches_count ?? 0 }}</td>
                        <td style="text-align:center;">{{ $origin->plants_count ?? 0 }}</td>
                        <td style="text-align:center;">
                            <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                <a href="{{ route('origins.edit', $origin->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger-outline" onclick="event.stopPropagation(); confirmDelete('{{ route('origins.destroy', $origin->id) }}', '{{ addslashes($origin->name) }}')">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;">
            {{ $origins->links() }}
        </div>
    @endif
</div>

@include('partials.delete-modal')
@endsection
