@extends('layouts.app')

@section('title', 'Add Origin — Forest Nursery')
@section('page-title', 'Add New Origin')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Origin Details
        </div>

        <form action="{{ route('origins.store') }}" method="POST" class="form-stack">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="name">Name <span class="text-red">*</span></label>
                    <input type="text" name="name" id="name" class="form-input @error('name') form-input-error @enderror" value="{{ old('name') }}" required placeholder="e.g. Borneo Rainforest">
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="region_code">Region Code <span class="text-red">*</span></label>
                    <input type="text" name="region_code" id="region_code" class="form-input @error('region_code') form-input-error @enderror" value="{{ old('region_code') }}" required placeholder="e.g. BRN-KAL">
                    @error('region_code') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="country">Country</label>
                <input type="text" name="country" id="country" class="form-input @error('country') form-input-error @enderror" value="{{ old('country') }}" placeholder="e.g. Indonesia">
                @error('country') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" class="form-input form-textarea @error('description') form-input-error @enderror" rows="3" placeholder="Optional description...">{{ old('description') }}</textarea>
                @error('description') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-divider"></div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="multiplier">Price Multiplier</label>
                    <input type="number" step="0.01" min="0" name="multiplier" id="multiplier" class="form-input" value="{{ old('multiplier') }}" placeholder="e.g. 1.50">
                    <span class="form-hint">Optional. Sets a pricing premium for this origin.</span>
                </div>
                <div class="form-group">
                    <label class="form-label" for="multiplier_notes">Multiplier Notes</label>
                    <input type="text" name="multiplier_notes" id="multiplier_notes" class="form-input" value="{{ old('multiplier_notes') }}" placeholder="e.g. Premium origin">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('origins.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Origin</button>
            </div>
        </form>
    </div>
</div>
@endsection
