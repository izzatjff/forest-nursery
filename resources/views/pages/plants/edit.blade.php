@extends('layouts.app')

@section('title', 'Edit Plant — Forest Nursery')
@section('page-title', 'Edit Plant')
@section('page-icon')
    <svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit: {{ substr($plant->uuid, 0, 8) }}…
        </div>

        <form action="{{ route('plants.update', $plant->uuid) }}" method="POST" class="form-stack">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="height_cm">Height (cm)</label>
                    <input type="number" step="0.01" min="0" name="height_cm" id="height_cm" class="form-input @error('height_cm') form-input-error @enderror" value="{{ old('height_cm', $plant->height_cm) }}">
                    @error('height_cm') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-input @error('location') form-input-error @enderror" value="{{ old('location', $plant->location) }}">
                    @error('location') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="health_status">Health Status</label>
                    <select name="health_status" id="health_status" class="form-input @error('health_status') form-input-error @enderror">
                        @foreach(['healthy', 'diseased', 'damaged', 'dead'] as $status)
                            <option value="{{ $status }}" {{ old('health_status', $plant->health_status) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('health_status') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="growth_stage">Growth Stage</label>
                    <select name="growth_stage" id="growth_stage" class="form-input @error('growth_stage') form-input-error @enderror">
                        @foreach(['seedling', 'juvenile', 'mature', 'ready_for_sale'] as $stage)
                            <option value="{{ $stage }}" {{ old('growth_stage', $plant->growth_stage) === $stage ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $stage)) }}</option>
                        @endforeach
                    </select>
                    @error('growth_stage') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="tray_number">Tray Number</label>
                <input type="text" name="tray_number" id="tray_number" class="form-input @error('tray_number') form-input-error @enderror" value="{{ old('tray_number', $plant->tray_number) }}">
                @error('tray_number') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <textarea name="notes" id="notes" class="form-input form-textarea @error('notes') form-input-error @enderror" rows="3">{{ old('notes', $plant->notes) }}</textarea>
                @error('notes') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('plants.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Plant</button>
            </div>
        </form>
    </div>
</div>
@endsection
