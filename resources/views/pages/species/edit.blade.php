@extends('layouts.app')

@section('title', 'Edit Species — Forest Nursery')
@section('page-title', 'Edit Species')
@section('page-icon')
<svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L3 7l9 5 9-5-9-5z"/><path d="M3 17l9 5 9-5"/><path d="M3 12l9 5 9-5"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit: {{ $species->name }}
        </div>

        <form action="{{ route('species.update', $species->id) }}" method="POST" class="form-stack">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Common Name <span class="text-red">*</span></label>
                <input type="text" name="name" id="name" class="form-input @error('name') form-input-error @enderror" value="{{ old('name', $species->name) }}" required>
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="scientific_name">Scientific Name <span class="text-red">*</span></label>
                <input type="text" name="scientific_name" id="scientific_name" class="form-input @error('scientific_name') form-input-error @enderror" value="{{ old('scientific_name', $species->scientific_name) }}" required>
                @error('scientific_name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="base_price">Base Price (RM) <span class="text-red">*</span></label>
                    <input type="number" step="0.01" min="0" name="base_price" id="base_price" class="form-input @error('base_price') form-input-error @enderror" value="{{ old('base_price', $species->base_price) }}" required>
                    @error('base_price') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="low_stock_threshold">Low Stock Threshold</label>
                    <input type="number" min="0" name="low_stock_threshold" id="low_stock_threshold" class="form-input @error('low_stock_threshold') form-input-error @enderror" value="{{ old('low_stock_threshold', $species->low_stock_threshold) }}">
                    @error('low_stock_threshold') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" class="form-input form-textarea @error('description') form-input-error @enderror" rows="3">{{ old('description', $species->description) }}</textarea>
                @error('description') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('species.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Species</button>
            </div>
        </form>
    </div>
</div>
@endsection
