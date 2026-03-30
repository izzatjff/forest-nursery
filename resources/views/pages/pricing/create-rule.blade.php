@extends('layouts.app')

@section('title', 'Add Pricing Rule — Forest Nursery')
@section('page-title', 'Add Pricing Rule')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Rule Details
        </div>

        <form action="{{ route('pricing.rules.store') }}" method="POST" class="form-stack">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Rule Name <span class="text-red">*</span></label>
                <input type="text" name="name" id="name" class="form-input @error('name') form-input-error @enderror" value="{{ old('name') }}" required placeholder="e.g. Seasonal Discount">
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="rule_type">Rule Type <span class="text-red">*</span></label>
                    <select name="rule_type" id="rule_type" class="form-input @error('rule_type') form-input-error @enderror" required>
                        <option value="discount" {{ old('rule_type') === 'discount' ? 'selected' : '' }}>Discount</option>
                        <option value="markup" {{ old('rule_type') === 'markup' ? 'selected' : '' }}>Markup</option>
                        <option value="bulk_discount" {{ old('rule_type') === 'bulk_discount' ? 'selected' : '' }}>Bulk Discount</option>
                        <option value="seasonal" {{ old('rule_type') === 'seasonal' ? 'selected' : '' }}>Seasonal</option>
                    </select>
                    @error('rule_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="entity_type">Entity Type <span class="text-red">*</span></label>
                    <select name="entity_type" id="entity_type" class="form-input @error('entity_type') form-input-error @enderror" required>
                        <option value="seed_batch" {{ old('entity_type') === 'seed_batch' ? 'selected' : '' }}>Seed Batch</option>
                        <option value="plant" {{ old('entity_type') === 'plant' ? 'selected' : '' }}>Plant</option>
                        <option value="all" {{ old('entity_type') === 'all' ? 'selected' : '' }}>All</option>
                    </select>
                    @error('entity_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="multiplier">Multiplier <span class="text-red">*</span></label>
                    <input type="number" step="0.01" min="0" name="multiplier" id="multiplier" class="form-input @error('multiplier') form-input-error @enderror" value="{{ old('multiplier', '1.00') }}" required>
                    <span class="form-hint">1.00 = no change, 0.85 = 15% discount, 1.20 = 20% markup</span>
                    @error('multiplier') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="flat_adjustment">Flat Adjustment ($)</label>
                    <input type="number" step="0.01" name="flat_adjustment" id="flat_adjustment" class="form-input @error('flat_adjustment') form-input-error @enderror" value="{{ old('flat_adjustment', '0.00') }}" placeholder="0.00">
                    <span class="form-hint">Added after multiplier. Use negative for discount.</span>
                    @error('flat_adjustment') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="priority">Priority <span class="text-red">*</span></label>
                    <input type="number" min="0" name="priority" id="priority" class="form-input @error('priority') form-input-error @enderror" value="{{ old('priority', 0) }}" required>
                    <span class="form-hint">Lower number = applied first</span>
                    @error('priority') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="is_active">Status</label>
                    <select name="is_active" id="is_active" class="form-input">
                        <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="criteria">Criteria (JSON)</label>
                <textarea name="criteria" id="criteria" class="form-input form-textarea @error('criteria') form-input-error @enderror" rows="3" placeholder='{"min_quantity": 100}'>{{ old('criteria') }}</textarea>
                <span class="form-hint">Optional JSON criteria for conditional application</span>
                @error('criteria') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('pricing.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Rule</button>
            </div>
        </form>
    </div>
</div>
@endsection
