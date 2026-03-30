@extends('layouts.app')

@section('title', 'Edit Seed Batch — Forest Nursery')
@section('page-title', 'Edit Seed Batch')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a5 5 0 0 1 5 5c0 2.76-5 8-5 8s-5-5.24-5-8a5 5 0 0 1 5-5z"/><circle cx="12" cy="7" r="1.5"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit: {{ $seedBatch->batch_code }}
        </div>

        <form action="{{ route('seed-batches.update', $seedBatch->id) }}" method="POST" class="form-stack">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="remaining_quantity">Remaining Quantity</label>
                <input type="number" step="0.01" min="0" name="remaining_quantity" id="remaining_quantity" class="form-input @error('remaining_quantity') form-input-error @enderror" value="{{ old('remaining_quantity', $seedBatch->remaining_quantity) }}">
                <span class="form-hint">Initial: {{ number_format($seedBatch->initial_quantity) }} {{ $seedBatch->unit }}</span>
                @error('remaining_quantity') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="storage_location">Storage Location</label>
                <input type="text" name="storage_location" id="storage_location" class="form-input @error('storage_location') form-input-error @enderror" value="{{ old('storage_location', $seedBatch->storage_location) }}">
                @error('storage_location') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="viability_percentage">Viability (%)</label>
                <input type="number" step="0.01" min="0" max="100" name="viability_percentage" id="viability_percentage" class="form-input @error('viability_percentage') form-input-error @enderror" value="{{ old('viability_percentage', $seedBatch->viability_percentage) }}">
                @error('viability_percentage') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <textarea name="notes" id="notes" class="form-input form-textarea @error('notes') form-input-error @enderror" rows="3">{{ old('notes', $seedBatch->notes) }}</textarea>
                @error('notes') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('seed-batches.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Seed Batch</button>
            </div>
        </form>
    </div>
</div>
@endsection
