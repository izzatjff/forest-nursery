@extends('layouts.app')

@section('title', 'Add Origin Multiplier — Forest Nursery')
@section('page-title', 'Add Origin Multiplier')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:480px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Origin Multiplier
        </div>

        <form action="{{ route('pricing.multipliers.store') }}" method="POST" class="form-stack">
            @csrf

            <div class="form-group">
                <label class="form-label" for="origin_id">Origin <span class="text-red">*</span></label>
                <select name="origin_id" id="origin_id" class="form-input @error('origin_id') form-input-error @enderror" required>
                    <option value="">Select origin...</option>
                    @foreach($origins as $origin)
                        <option value="{{ $origin->id }}" {{ old('origin_id') == $origin->id ? 'selected' : '' }}>{{ $origin->name }} ({{ $origin->region_code }})</option>
                    @endforeach
                </select>
                @error('origin_id') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="multiplier">Multiplier <span class="text-red">*</span></label>
                <input type="number" step="0.01" min="0" name="multiplier" id="multiplier" class="form-input @error('multiplier') form-input-error @enderror" value="{{ old('multiplier') }}" required placeholder="e.g. 1.50">
                <span class="form-hint">1.00 = base price, 1.50 = 50% premium, 0.80 = 20% discount</span>
                @error('multiplier') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <input type="text" name="notes" id="notes" class="form-input" value="{{ old('notes') }}" placeholder="e.g. Premium origin">
            </div>

            <div class="form-actions">
                <a href="{{ route('pricing.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Multiplier</button>
            </div>
        </form>
    </div>
</div>
@endsection
