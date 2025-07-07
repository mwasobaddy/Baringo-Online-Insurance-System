@php
/**
 * Policy Types CRUD (Volt v3)
 * Migrated from Livewire class-based component
 */
@endphp

<form wire:submit="save">
    <label for="name">Name</label>
    <input type="text" wire:model="name" id="name" required>
    <label for="description">Description</label>
    <input type="text" wire:model="description" id="description">
    <label for="base_premium">Base Premium</label>
    <input type="number" wire:model="base_premium" id="base_premium" required min="0">
    <label for="coverage_details">Coverage Details</label>
    <input type="text" wire:model="coverage_details" id="coverage_details">
    <button type="submit">Save</button>
</form>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<!-- List of Policy Types -->
<ul>
    @foreach($policyTypes as $type)
        <li>{{ $type->name }} (KES {{ $type->base_premium }})</li>
    @endforeach
</ul>
