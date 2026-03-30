@extends('layouts.app')

@section('title', 'Plant ' . substr($plant->uuid, 0, 8) . ' — Forest Nursery')
@section('page-title', 'Plant Details')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/></svg>
@endsection

@section('page-actions')
<a href="{{ route('plants.edit', $plant->uuid) }}" class="btn btn-secondary">
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
                Plant Information
            </div>
            <div class="detail-grid">
                <div class="detail-item" style="grid-column:1/-1;">
                    <dt>UUID</dt>
                    <dd style="font-family:var(--font-mono);font-size:12px;">{{ $plant->uuid }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Species</dt>
                    <dd><a href="{{ route('species.show', $plant->species->id) }}" style="color:#0f172a;text-decoration:none;font-weight:500;">{{ $plant->species->name ?? '—' }}</a></dd>
                </div>
                <div class="detail-item">
                    <dt>Origin</dt>
                    <dd>{{ $plant->origin->name ?? '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Seed Batch</dt>
                    <dd>
                        @if($plant->seed_batch)
                            <a href="{{ route('seed-batches.show', $plant->seed_batch->id) }}" style="font-family:var(--font-mono);font-size:12px;color:#0f172a;text-decoration:none;">{{ $plant->seed_batch->batch_code }}</a>
                        @else
                            —
                        @endif
                    </dd>
                </div>
                <div class="detail-item">
                    <dt>Potting Date</dt>
                    <dd>{{ ($plant->potting_date ? date('M d, Y', strtotime($plant->potting_date)) : null) ?? '—' }}</dd>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                Growth & Status
            </div>
            <div class="detail-grid">
                <div class="detail-item">
                    <dt>Height</dt>
                    <dd style="font-family:var(--font-mono);font-size:18px;font-weight:700;">{{ $plant->height_cm }}<span style="color:#94a3b8;font-weight:400;margin-left:2px;font-size:13px;">cm</span></dd>
                </div>
                <div class="detail-item">
                    <dt>Health Status</dt>
                    <dd>
                        @php
                            $hMap = ['healthy'=>'emerald','diseased'=>'red','damaged'=>'amber','dead'=>'gray'];
                            $hColor = $hMap[$plant->health_status] ?? 'gray';
                        @endphp
                        <span class="badge badge-{{ $hColor }}"><span class="badge-dot"></span>{{ ucfirst($plant->health_status) }}</span>
                    </dd>
                </div>
                <div class="detail-item">
                    <dt>Growth Stage</dt>
                    <dd>
                        @php
                            $sMap = ['seedling'=>'blue','juvenile'=>'violet','mature'=>'emerald','ready_for_sale'=>'amber'];
                            $sColor = $sMap[$plant->growth_stage] ?? 'gray';
                        @endphp
                        <span class="badge badge-{{ $sColor }}"><span class="badge-dot"></span>{{ ucfirst(str_replace('_', ' ', $plant->growth_stage)) }}</span>
                    </dd>
                </div>
                <div class="detail-item">
                    <dt>Sale Status</dt>
                    <dd>
                        @if($plant->is_sold)
                            <span class="badge badge-gray">Sold</span>
                        @else
                            <span class="badge badge-emerald"><span class="badge-dot"></span>Available</span>
                        @endif
                    </dd>
                </div>
                <div class="detail-item">
                    <dt>Tray</dt>
                    <dd>{{ $plant->tray_number ?? '—' }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Location</dt>
                    <dd>{{ $plant->location ?? '—' }}</dd>
                </div>
                @if($plant->notes)
                <div class="detail-item" style="grid-column:1/-1;">
                    <dt>Notes</dt>
                    <dd>{{ $plant->notes }}</dd>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<a href="{{ route('plants.index') }}" class="btn btn-secondary">&larr; Back to Plants</a>
@endsection
