@extends('layouts.app')

@section('title', 'Plants — Forest Nursery')
@section('page-title', 'Plants Inventory')
@section('page-icon')
    <svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>
@endsection

@section('page-actions')
<a href="{{ route('plants.create') }}" class="btn btn-primary">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Plant
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>
            All Plants
        </div>
    </div>

    @if($plants->isEmpty())
        <div style="padding:24px;">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>
                </div>
                <div class="empty-state-title">No plants in stock</div>
                <div class="empty-state-text">Germinate seeds to grow your first plants</div>
            </div>
        </div>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>UUID</th>
                        <th>Species</th>
                        <th style="text-align:center;">Height</th>
                        <th style="text-align:center;">Health</th>
                        <th style="text-align:center;">Stage</th>
                        <th>Location</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plants as $plant)
                    <tr class="hover:cursor-pointer" onclick="window.location.href='{{ route('plants.show', $plant->uuid) }}';">
                        <td style="font-family:var(--font-mono);font-size:11.5px;color:#64748b;text-decoration:none;">
                            {{ substr($plant->uuid, 0, 8) }}…
                        </td>
                        <td style="font-weight:500;">{{ $plant->species->name ?? '—' }}</td>
                        <td style="text-align:center;font-family:var(--font-mono);font-size:13px;font-weight:600;">{{ $plant->height_cm }}<span style="color:#94a3b8;font-weight:400;margin-left:2px;">cm</span></td>
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
                        <td style="color:#64748b;">{{ $plant->location ?? '—' }}</td>
                        <td style="text-align:center;">
                            @if($plant->is_sold)
                                <span class="badge badge-gray">Sold</span>
                            @else
                                <span class="badge badge-emerald"><span class="badge-dot"></span>Available</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                <a href="{{ route('plants.edit', $plant->uuid) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger-outline" onclick="event.stopPropagation(); confirmDelete('{{ route('plants.destroy', $plant->uuid) }}', '{{ substr($plant->uuid, 0, 8) }}')">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;">
            {{ $plants->links() }}
        </div>
    @endif
</div>

@include('partials.delete-modal')
@endsection
