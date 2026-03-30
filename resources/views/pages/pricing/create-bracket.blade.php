@extends('layouts.app')

@section('title', 'Add Height Bracket — Forest Nursery')
@section('page-title', 'Add Height Bracket')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:480px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Height Price Bracket
        </div>

        <form action="{{ route('pricing.brackets.store') }}" method="POST" class="form-stack">
            @csrf

            <div class="form-group">
                <label class="form-label" for="species_id">Species (optional)</label>
                <select name="species_id" id="species_id" class="form-input @error('species_id') form-input-error @enderror">
                    <option value="">All Species</option>
                    @foreach($species as $sp)
                        <option value="{{ $sp->id }}" {{ old('species_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                    @endforeach
                </select>
                <span class="form-hint">Leave blank to apply to all species</span>
                @error('species_id') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="min_height_cm">Min Height (cm) <span class="text-red">*</span></label>
                    <input type="number" step="0.01" min="0" name="min_height_cm" id="min_height_cm" class="form-input @error('min_height_cm') form-input-error @enderror" value="{{ old('min_height_cm') }}" required placeholder="0">
                    @error('min_height_cm') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="max_height_cm">Max Height (cm)</label>
                    <input type="number" step="0.01" min="0" name="max_height_cm" id="max_height_cm" class="form-input @error('max_height_cm') form-input-error @enderror" value="{{ old('max_height_cm') }}" placeholder="∞ (leave blank)">
                    @error('max_height_cm') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="multiplier">Multiplier <span class="text-red">*</span></label>
                <input type="number" step="0.01" min="0" name="multiplier" id="multiplier" class="form-input @error('multiplier') form-input-error @enderror" value="{{ old('multiplier') }}" required placeholder="e.g. 2.00">
                <span class="form-hint">Price multiplier for plants in this height range</span>
                @error('multiplier') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('pricing.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Bracket</button>
            </div>
        </form>
    </div>
</div>
@endsection
