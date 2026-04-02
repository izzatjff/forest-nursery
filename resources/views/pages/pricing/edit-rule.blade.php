@extends('layouts.app')

@section('title', 'Edit Pricing Rule — Forest Nursery')
@section('page-title', 'Edit Pricing Rule')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit: {{ $pricingRule->name }}
        </div>

        <form action="{{ route('pricing.rules.update', $pricingRule->id) }}" method="POST" class="form-stack">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Rule Name <span class="text-red">*</span></label>
                <input type="text" name="name" id="name" class="form-input @error('name') form-input-error @enderror" value="{{ old('name', $pricingRule->name) }}" required>
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="rule_type">Rule Type <span class="text-red">*</span></label>
                    <select name="rule_type" id="rule_type" class="form-input @error('rule_type') form-input-error @enderror" required>
                        @foreach(['discount', 'markup', 'bulk_discount', 'seasonal'] as $type)
                            <option value="{{ $type }}" {{ old('rule_type', $pricingRule->rule_type) === $type ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                        @endforeach
                    </select>
                    @error('rule_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="entity_type">Entity Type <span class="text-red">*</span></label>
                    <select name="entity_type" id="entity_type" class="form-input @error('entity_type') form-input-error @enderror" required>
                        @foreach(['seed_batch', 'plant', 'all'] as $etype)
                            <option value="{{ $etype }}" {{ old('entity_type', $pricingRule->entity_type) === $etype ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $etype)) }}</option>
                        @endforeach
                    </select>
                    @error('entity_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="multiplier">Multiplier <span class="text-red">*</span></label>
                    <input type="number" step="0.01" min="0" name="multiplier" id="multiplier" class="form-input @error('multiplier') form-input-error @enderror" value="{{ old('multiplier', $pricingRule->multiplier) }}" required>
                    @error('multiplier') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="flat_adjustment">Flat Adjustment ($)</label>
                    <input type="number" step="0.01" name="flat_adjustment" id="flat_adjustment" class="form-input @error('flat_adjustment') form-input-error @enderror" value="{{ old('flat_adjustment', $pricingRule->flat_adjustment) }}">
                    @error('flat_adjustment') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="priority">Priority <span class="text-red">*</span></label>
                    <input type="number" min="0" name="priority" id="priority" class="form-input @error('priority') form-input-error @enderror" value="{{ old('priority', $pricingRule->priority) }}" required>
                    @error('priority') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="is_active">Status</label>
                    <select name="is_active" id="is_active" class="form-input">
                        <option value="1" {{ old('is_active', $pricingRule->is_active) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !old('is_active', $pricingRule->is_active) ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="criteria">Criteria (JSON)</label>
                <textarea name="criteria" id="criteria" class="form-input form-textarea @error('criteria') form-input-error @enderror" rows="3">{{ old('criteria', (is_array($pricingRule->criteria) || is_object($pricingRule->criteria)) ? json_encode($pricingRule->criteria, JSON_PRETTY_PRINT) : $pricingRule->criteria) }}</textarea>
                @error('criteria') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('pricing.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Rule</button>
            </div>
        </form>
    </div>
</div>
@endsection
