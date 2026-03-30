@extends('layouts.app')

@section('title', 'New Sale — Forest Nursery')
@section('page-title', 'Record New Sale')
@section('page-icon')
    <svg class="topbar-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
@endsection

@section('content')
<div class="card" style="max-width:720px;">
    <div class="card-body">
        <div class="card-title">
            <svg class="card-title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Sale Details
        </div>

        <form action="{{ route('sales.store') }}" method="POST" class="form-stack" id="sale-form">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="customer_name">Customer Name</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-input" value="{{ old('customer_name') }}" placeholder="Walk-in customer">
                </div>
                <div class="form-group">
                    <label class="form-label" for="customer_contact">Contact</label>
                    <input type="text" name="customer_contact" id="customer_contact" class="form-input" value="{{ old('customer_contact') }}" placeholder="Phone or email">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="payment_method">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-input">
                    <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Card</option>
                    <option value="transfer" {{ old('payment_method') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                </select>
            </div>

            <div class="form-divider"></div>

            <div style="margin-bottom:16px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                    <label class="form-label" style="margin-bottom:0;">Sale Items <span class="text-red">*</span></label>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="addSaleItem()">+ Add Item</button>
                </div>
                <div id="sale-items">
                    <div class="sale-item-row" data-index="0">
                        <div class="form-row" style="margin-bottom:8px;">
                            <div class="form-group" style="flex:1;">
                                <select name="items[0][item_type]" class="form-input item-type-select" onchange="toggleItemFields(this, 0)">
                                    <option value="seed_batch">Seed Batch</option>
                                    <option value="plant">Plant</option>
                                </select>
                            </div>
                            <div class="form-group item-batch-field" style="flex:2;">
                                <select name="items[0][seed_batch_id]" class="form-input">
                                    <option value="">Select batch...</option>
                                    @foreach($seedBatches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->batch_code }} — {{ $batch->species->name ?? '' }} ({{ number_format($batch->remaining_quantity) }} left)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group item-plant-field" style="flex:2;display:none;">
                                <select name="items[0][plant_uuid]" class="form-input" disabled>
                                    <option value="">Select plant...</option>
                                    @foreach($plants as $plant)
                                        <option value="{{ $plant->uuid }}">{{ substr($plant->uuid, 0, 8) }}… — {{ $plant->species->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group item-qty-field" style="flex:1;">
                                <input type="number" step="0.01" min="0.01" name="items[0][quantity]" class="form-input" placeholder="Qty">
                            </div>
                            <button type="button" class="btn btn-sm btn-danger-outline" onclick="removeSaleItem(this)" style="align-self:center;">&times;</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <textarea name="notes" id="notes" class="form-input form-textarea" rows="2" placeholder="Optional notes...">{{ old('notes') }}</textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Process Sale</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
let itemIndex = 1;

function addSaleItem() {
    const container = document.getElementById('sale-items');
    const template = container.querySelector('.sale-item-row').cloneNode(true);
    const idx = itemIndex++;
    template.dataset.index = idx;

    // Update names
    template.querySelectorAll('[name]').forEach(el => {
        el.name = el.name.replace(/\[\d+\]/, '[' + idx + ']');
        if (el.tagName === 'SELECT') el.selectedIndex = 0;
        if (el.tagName === 'INPUT') el.value = '';
    });

    // Reset visibility
    template.querySelector('.item-batch-field').style.display = '';
    template.querySelector('.item-plant-field').style.display = 'none';
    template.querySelector('.item-plant-field select').disabled = true;
    template.querySelector('.item-batch-field select').disabled = false;
    template.querySelector('.item-qty-field').style.display = '';

    container.appendChild(template);
}

function removeSaleItem(btn) {
    const container = document.getElementById('sale-items');
    if (container.children.length > 1) {
        btn.closest('.sale-item-row').remove();
    }
}

function toggleItemFields(select, index) {
    const row = select.closest('.sale-item-row');
    const batchField = row.querySelector('.item-batch-field');
    const plantField = row.querySelector('.item-plant-field');
    const qtyField = row.querySelector('.item-qty-field');

    if (select.value === 'plant') {
        batchField.style.display = 'none';
        batchField.querySelector('select').disabled = true;
        plantField.style.display = '';
        plantField.querySelector('select').disabled = false;
        qtyField.style.display = 'none';
    } else {
        batchField.style.display = '';
        batchField.querySelector('select').disabled = false;
        plantField.style.display = 'none';
        plantField.querySelector('select').disabled = true;
        qtyField.style.display = '';
    }
}
</script>
@endsection
