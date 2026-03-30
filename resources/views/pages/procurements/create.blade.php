@extends('layouts.app')

@section('title', 'New Procurement — Forest Nursery')
@section('page-title', 'Record Procurement')
@section('page-icon')
    <svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Procurement Details
        </div>
        <p style="font-size:13px;color:#64748b;margin-bottom:20px;">This will also create a new seed batch automatically.</p>

        <form action="{{ route('procurements.store') }}" method="POST" class="form-stack">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="supplier_name">Supplier Name <span class="text-red">*</span></label>
                    <input type="text" name="supplier_name" id="supplier_name" class="form-input @error('supplier_name') form-input-error @enderror" value="{{ old('supplier_name') }}" required placeholder="e.g. Green Seeds Co.">
                    @error('supplier_name') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="supplier_contact">Supplier Contact</label>
                    <input type="text" name="supplier_contact" id="supplier_contact" class="form-input @error('supplier_contact') form-input-error @enderror" value="{{ old('supplier_contact') }}" placeholder="Phone or email">
                    @error('supplier_contact') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

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
                        <option value="donated" {{ old('source_type') === 'donated' ? 'selected' : '' }}>Donated</option>
                    </select>
                    @error('source_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="received_date">Received Date <span class="text-red">*</span></label>
                    <input type="date" name="received_date" id="received_date" class="form-input @error('received_date') form-input-error @enderror" value="{{ old('received_date') }}" required>
                    @error('received_date') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="quantity">Quantity <span class="text-red">*</span></label>
                    <input type="number" step="0.01" min="0.01" name="quantity" id="quantity" class="form-input @error('quantity') form-input-error @enderror" value="{{ old('quantity') }}" required placeholder="0">
                    @error('quantity') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="unit">Unit</label>
                    <select name="unit" id="unit" class="form-input">
                        <option value="pieces" {{ old('unit') === 'pieces' ? 'selected' : '' }}>Pieces</option>
                        <option value="grams" {{ old('unit') === 'grams' ? 'selected' : '' }}>Grams</option>
                        <option value="kg" {{ old('unit') === 'kg' ? 'selected' : '' }}>Kilograms</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="cost_per_unit">Cost per Unit ($)</label>
                    <input type="number" step="0.01" min="0" name="cost_per_unit" id="cost_per_unit" class="form-input @error('cost_per_unit') form-input-error @enderror" value="{{ old('cost_per_unit') }}" placeholder="0.00">
                    @error('cost_per_unit') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <textarea name="notes" id="notes" class="form-input form-textarea @error('notes') form-input-error @enderror" rows="3" placeholder="Optional notes...">{{ old('notes') }}</textarea>
                @error('notes') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('procurements.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Record Procurement</button>
            </div>
        </form>
    </div>
</div>
@endsection
