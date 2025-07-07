@php
/**
 * Policy Renewal (Volt v3)
 * Migrated from Livewire class-based component
 */
@endphp

<form wire:submit="renew">
    <label for="selectedPolicyId">Select Policy</label>
    <select wire:model="selectedPolicyId" id="selectedPolicyId" required>
        <option value="">Select Policy</option>
        @foreach($policies as $policy)
            <option value="{{ $policy->id }}">{{ $policy->policy_number }}</option>
        @endforeach
    </select>
    <label for="renewalDate">Renewal Date</label>
    <input type="date" wire:model="renewalDate" id="renewalDate" required>
    <label for="premiumAmount">Premium Amount</label>
    <input type="number" wire:model="premiumAmount" id="premiumAmount" required min="0">
    <button type="submit">Renew</button>
</form>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
