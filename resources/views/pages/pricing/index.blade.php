@extends('layouts.app')

@section('title', 'Pricing Engine — Forest Nursery')
@section('page-title', 'Pricing Engine')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(360px,1fr));gap:20px;margin-bottom:20px;">

    <!-- Origin Multipliers -->
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div class="card-title" style="margin-bottom:0;">
                    <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    Origin Multipliers
                </div>
                <a href="{{ route('pricing.multipliers.create') }}" class="btn btn-sm btn-primary">+ Add</a>
            </div>

            @if($multipliers->isEmpty())
                <div class="empty-state" style="padding:20px 0;">
                    <div class="empty-state-title" style="font-size:13px;">No multipliers</div>
                    <div class="empty-state-text">Set origin-based pricing premiums</div>
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($multipliers as $m)
                        <div class="pricing-row">
                            <div>
                                <div class="pricing-row-label">{{ $m->origin->name ?? 'Origin #' . $m->origin_id }}</div>
                                <div class="pricing-row-sub">{{ $m->notes ?: 'No notes' }}</div>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div class="pricing-row-value pricing-row-value-green">{{ number_format($m->multiplier, 2) }}&times;</div>
                                <form action="{{ route('pricing.multipliers.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Delete this multiplier?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger-outline">&times;</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Height Brackets -->
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div class="card-title" style="margin-bottom:0;">
                    <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 6L12 2l4 4"/><path d="M12 2v10"/><rect x="6" y="14" width="12" height="8" rx="2"/></svg>
                    Height Price Brackets
                </div>
                <a href="{{ route('pricing.brackets.create') }}" class="btn btn-sm btn-primary">+ Add</a>
            </div>

            @if($brackets->isEmpty())
                <div class="empty-state" style="padding:20px 0;">
                    <div class="empty-state-title" style="font-size:13px;">No brackets</div>
                    <div class="empty-state-text">Define height-based pricing tiers</div>
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($brackets as $b)
                        <div class="pricing-row">
                            <div>
                                <div class="pricing-row-label">{{ $b->species->name ?? 'All Species' }}</div>
                                <div class="pricing-row-sub">{{ number_format($b->min_height_cm) }} – {{ $b->max_height_cm ? number_format($b->max_height_cm) : '∞' }} cm</div>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div class="pricing-row-value pricing-row-value-blue">{{ number_format($b->multiplier, 2) }}&times;</div>
                                <form action="{{ route('pricing.brackets.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Delete this bracket?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger-outline">&times;</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Pricing Rules -->
{{-- <div class="card">
    <div class="card-body">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <div class="card-title" style="margin-bottom:0;">
                <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                Active Pricing Rules
            </div>
            <a href="{{ route('pricing.rules.create') }}" class="btn btn-sm btn-primary">+ Add Rule</a>
        </div>

        @if($rules->isEmpty())
            <div class="empty-state" style="padding:20px 0;">
                <div class="empty-state-title" style="font-size:13px;">No pricing rules</div>
                <div class="empty-state-text">Create rules like seasonal discounts or bulk pricing</div>
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:8px;">
                @foreach($rules as $r)
                    @php
                        $valueStr = number_format($r->multiplier, 2) . '×';
                        if ($r->flat_adjustment != 0) {
                            $valueStr .= ($r->flat_adjustment > 0 ? ' + ' : ' − ') . '$' . number_format(abs($r->flat_adjustment), 2);
                        }
                    @endphp
                    <div class="pricing-row">
                        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                            <div>
                                <div class="pricing-row-label">{{ $r->name }}</div>
                                <div class="pricing-row-sub" style="display:flex;align-items:center;gap:6px;margin-top:3px;">
                                    @if($r->is_active)
                                        <span class="badge badge-emerald"><span class="badge-dot"></span>Active</span>
                                    @else
                                        <span class="badge badge-gray"><span class="badge-dot"></span>Inactive</span>
                                    @endif
                                    <span class="badge badge-gray">{{ $r->entity_type }}</span>
                                    <span class="badge badge-gray">{{ str_replace('_', ' ', $r->rule_type) }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div class="pricing-row-value pricing-row-value-green">{{ $valueStr }}</div>
                            <a href="{{ route('pricing.rules.edit', $r->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('pricing.rules.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Delete this rule?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger-outline">&times;</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="padding-top:16px;">
                {{ $rules->links() }}
            </div>
        @endif
    </div>
</div> --}}
@endsection
