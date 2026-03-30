@extends('layouts.app')

@section('title', $origin->name . ' — Forest Nursery')
@section('page-title', $origin->name)
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
@endsection

@section('page-actions')
<a href="{{ route('origins.edit', $origin->id) }}" class="btn btn-secondary">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
    Edit
</a>
@endsection

@section('content')
<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            Origin Information
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <dt>Name</dt>
                <dd>{{ $origin->name }}</dd>
            </div>
            <div class="detail-item">
                <dt>Region Code</dt>
                <dd><span class="badge badge-gray">{{ $origin->region_code }}</span></dd>
            </div>
            <div class="detail-item">
                <dt>Country</dt>
                <dd>{{ $origin->country ?? '—' }}</dd>
            </div>
            <div class="detail-item">
                <dt>Price Multiplier</dt>
                <dd style="font-family:var(--font-mono);font-weight:600;color:#16a34a;">{{ $origin->price_multiplier ? number_format($origin->price_multiplier->multiplier, 2) . '×' : '1.00× (default)' }}</dd>
            </div>
            @if($origin->description)
            <div class="detail-item" style="grid-column:1/-1;">
                <dt>Description</dt>
                <dd>{{ $origin->description }}</dd>
            </div>
            @endif
        </div>
    </div>
</div>

<a href="{{ route('origins.index') }}" class="btn btn-secondary">&larr; Back to Origins</a>
@endsection
