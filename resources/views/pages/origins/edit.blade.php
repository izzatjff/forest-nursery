@extends('layouts.app')

@section('title', 'Edit Origin — Forest Nursery')
@section('page-title', 'Edit Origin')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit: {{ $origin->name }}
        </div>

        <form action="{{ route('origins.update', $origin->id) }}" method="POST" class="form-stack">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="name">Name <span class="text-red">*</span></label>
                    <input type="text" name="name" id="name" class="form-input @error('name') form-input-error @enderror" value="{{ old('name', $origin->name) }}" required>
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="region_code">Region Code <span class="text-red">*</span></label>
                    <input type="text" name="region_code" id="region_code" class="form-input @error('region_code') form-input-error @enderror" value="{{ old('region_code', $origin->region_code) }}" required>
                    @error('region_code') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="country">Country</label>
                <input type="text" name="country" id="country" class="form-input @error('country') form-input-error @enderror" value="{{ old('country', $origin->country) }}">
                @error('country') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" class="form-input form-textarea @error('description') form-input-error @enderror" rows="3">{{ old('description', $origin->description) }}</textarea>
                @error('description') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-divider"></div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="multiplier">Price Multiplier</label>
                    <input type="number" step="0.01" min="0" name="multiplier" id="multiplier" class="form-input" value="{{ old('multiplier', $origin->price_multiplier?->multiplier) }}" placeholder="e.g. 1.50">
                </div>
                <div class="form-group">
                    <label class="form-label" for="multiplier_notes">Multiplier Notes</label>
                    <input type="text" name="multiplier_notes" id="multiplier_notes" class="form-input" value="{{ old('multiplier_notes', $origin->price_multiplier?->notes) }}">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('origins.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Origin</button>
            </div>
        </form>
    </div>
</div>
@endsection
