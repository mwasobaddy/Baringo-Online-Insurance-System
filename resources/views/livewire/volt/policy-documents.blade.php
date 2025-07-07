@php
/**
 * Policy Documents (Volt v3)
 * Migrated from Livewire class-based component
 */
@endphp

<ul>
    @foreach($policies as $policy)
        <li>
            Policy #: {{ $policy->policy_number }}
            <button wire:click="generateDocument({{ $policy->id }})">Generate Document</button>
            <button wire:click="downloadDocument({{ $policy->id }})">Download Document</button>
        </li>
    @endforeach
</ul>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if($documentUrl)
    <a href="{{ $documentUrl }}" target="_blank">View Generated Document</a>
@endif
