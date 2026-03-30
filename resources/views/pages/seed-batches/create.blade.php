@extends('layouts.app')

@section('title', 'Add Seed Batch — Forest Nursery')
@section('page-title', 'Add New Seed Batch')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a5 5 0 0 1 5 5c0 2.76-5 8-5 8s-5-5.24-5-8a5 5 0 0 1 5-5z"/><circle cx="12" cy="7" r="1.5"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Batch Details
        </div>

        <form action="{{ route('seed-batches.store') }}" method="POST" class="form-stack">
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

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="source_type">Source Type <span class="text-red">*</span></label>
                    <select name="source_type" id="source_type" class="form-input @error('source_type') form-input-error @enderror" required>
                        <option value="purchased" {{ old('source_type') === 'purchased' ? 'selected' : '' }}>Purchased</option>
                        <option value="wild_collected" {{ old('source_type') === 'wild_collected' ? 'selected' : '' }}>Wild Collected</option>
                    </select>
                    @error('source_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="collection_date">Collection Date <span class="text-red">*</span></label>
                    <input type="date" name="collection_date" id="collection_date" class="form-input @error('collection_date') form-input-error @enderror" value="{{ old('collection_date') }}" required>
                    @error('collection_date') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="initial_quantity">Initial Quantity <span class="text-red">*</span></label>
                    <input type="number" step="0.01" min="0.01" name="initial_quantity" id="initial_quantity" class="form-input @error('initial_quantity') form-input-error @enderror" value="{{ old('initial_quantity') }}" required placeholder="0">
                    @error('initial_quantity') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="unit">Unit</label>
                    <select name="unit" id="unit" class="form-input @error('unit') form-input-error @enderror">
                        <option value="pieces" {{ old('unit') === 'pieces' ? 'selected' : '' }}>Pieces</option>
                        <option value="grams" {{ old('unit') === 'grams' ? 'selected' : '' }}>Grams</option>
                        <option value="kg" {{ old('unit') === 'kg' ? 'selected' : '' }}>Kilograms</option>
                    </select>
                    @error('unit') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="supplier_name">Supplier Name</label>
                <input type="text" name="supplier_name" id="supplier_name" class="form-input @error('supplier_name') form-input-error @enderror" value="{{ old('supplier_name') }}" placeholder="e.g. Green Seeds Co.">
                @error('supplier_name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="storage_location">Storage Location</label>
                    <input type="text" name="storage_location" id="storage_location" class="form-input @error('storage_location') form-input-error @enderror" value="{{ old('storage_location') }}" placeholder="e.g. Warehouse A, Shelf 3">
                    @error('storage_location') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="viability_percentage">Viability (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="viability_percentage" id="viability_percentage" class="form-input @error('viability_percentage') form-input-error @enderror" value="{{ old('viability_percentage') }}" placeholder="0-100">
                    @error('viability_percentage') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <textarea name="notes" id="notes" class="form-input form-textarea @error('notes') form-input-error @enderror" rows="3" placeholder="Optional notes...">{{ old('notes') }}</textarea>
                @error('notes') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('seed-batches.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Seed Batch</button>
            </div>
        </form>
    </div>
</div>
@endsection
