@extends('layouts.app')

@section('title', 'Add Plant — Forest Nursery')
@section('page-title', 'Add New Plant')
@section('page-icon')
    <svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Plant Details
        </div>

        <form action="{{ route('plants.store') }}" method="POST" class="form-stack">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="species_id">Species <span class="text-red">*</span></label>
                    <select name="species_id" id="species_id" class="form-input @error('species_id') form-input-error @enderror" required>
                        <option value="">Select species...</option>
                        @foreach($species as $sp)
                            <option value="{{ $sp->id }}" {{ old('species_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                        @endforeach
                    </select>
                    @error('species_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="origin_id">Origin <span class="text-red">*</span></label>
                    <select name="origin_id" id="origin_id" class="form-input @error('origin_id') form-input-error @enderror" required>
                        <option value="">Select origin...</option>
                        @foreach($origins as $origin)
                            <option value="{{ $origin->id }}" {{ old('origin_id') == $origin->id ? 'selected' : '' }}>{{ $origin->name }}</option>
                        @endforeach
                    </select>
                    @error('origin_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="seed_batch_id">Seed Batch (Source)</label>
                <select name="seed_batch_id" id="seed_batch_id" class="form-input @error('seed_batch_id') form-input-error @enderror">
                    <option value="">None (manual entry)</option>
                    @foreach($seedBatches as $batch)
                        <option value="{{ $batch->id }}" {{ old('seed_batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->batch_code }} — {{ number_format($batch->remaining_quantity) }} remaining</option>
                    @endforeach
                </select>
                @error('seed_batch_id') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="height_cm">Height (cm)</label>
                    <input type="number" step="0.01" min="0" name="height_cm" id="height_cm" class="form-input @error('height_cm') form-input-error @enderror" value="{{ old('height_cm', 0) }}" placeholder="0">
                    @error('height_cm') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="potting_date">Potting Date</label>
                    <input type="date" name="potting_date" id="potting_date" class="form-input @error('potting_date') form-input-error @enderror" value="{{ old('potting_date') }}">
                    @error('potting_date') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="health_status">Health Status</label>
                    <select name="health_status" id="health_status" class="form-input @error('health_status') form-input-error @enderror">
                        <option value="healthy" {{ old('health_status') === 'healthy' ? 'selected' : '' }}>Healthy</option>
                        <option value="diseased" {{ old('health_status') === 'diseased' ? 'selected' : '' }}>Diseased</option>
                        <option value="damaged" {{ old('health_status') === 'damaged' ? 'selected' : '' }}>Damaged</option>
                        <option value="dead" {{ old('health_status') === 'dead' ? 'selected' : '' }}>Dead</option>
                    </select>
                    @error('health_status') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="growth_stage">Growth Stage</label>
                    <select name="growth_stage" id="growth_stage" class="form-input @error('growth_stage') form-input-error @enderror">
                        <option value="seedling" {{ old('growth_stage') === 'seedling' ? 'selected' : '' }}>Seedling</option>
                        <option value="juvenile" {{ old('growth_stage') === 'juvenile' ? 'selected' : '' }}>Juvenile</option>
                        <option value="mature" {{ old('growth_stage') === 'mature' ? 'selected' : '' }}>Mature</option>
                        <option value="ready_for_sale" {{ old('growth_stage') === 'ready_for_sale' ? 'selected' : '' }}>Ready for Sale</option>
                    </select>
                    @error('growth_stage') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="tray_number">Tray Number</label>
                    <input type="text" name="tray_number" id="tray_number" class="form-input @error('tray_number') form-input-error @enderror" value="{{ old('tray_number') }}" placeholder="e.g. T-001">
                    @error('tray_number') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-input @error('location') form-input-error @enderror" value="{{ old('location') }}" placeholder="e.g. Greenhouse B">
                    @error('location') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <textarea name="notes" id="notes" class="form-input form-textarea @error('notes') form-input-error @enderror" rows="3" placeholder="Optional notes...">{{ old('notes') }}</textarea>
                @error('notes') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('plants.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Plant</button>
            </div>
        </form>
    </div>
</div>
@endsection
