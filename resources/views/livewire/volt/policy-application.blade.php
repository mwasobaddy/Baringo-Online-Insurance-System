@php
/**
 * Policy Application (Volt v3)
 * Migrated from Livewire class-based component
 */
@endphp

<form wire:submit="submit">
    <!-- Step 1: Select Policy Type -->
    <div x-show="step === 1">
        <label for="policy_type_id">Policy Type</label>
        <select wire:model="policy_type_id" id="policy_type_id" required>
            <option value="">Select Type</option>
            @foreach($policyTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
        <button type="button" wire:click="nextStep">Next</button>
    </div>
    <!-- Step 2: Enter Details -->
    <div x-show="step === 2">
        <label for="start_date">Start Date</label>
        <input type="date" wire:model="start_date" id="start_date" required>
        <label for="coverage_amount">Coverage Amount</label>
        <input type="number" wire:model="coverage_amount" id="coverage_amount" required min="0">
        <button type="button" wire:click="previousStep">Back</button>
        <button type="submit">Submit</button>
    </div>
</form>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
