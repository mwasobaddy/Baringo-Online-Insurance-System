@php
/**
 * Policy Tracking (Volt v3)
 * Migrated from Livewire class-based component
 */
@endphp

<ul>
    @foreach($policies as $policy)
        <li>
            Policy #: {{ $policy->policy_number }}<br>
            Type: {{ $policy->policyType->name ?? 'N/A' }}<br>
            Status: {{ $policy->status }}<br>
            Start: {{ $policy->start_date }}<br>
            End: {{ $policy->end_date }}
        </li>
    @endforeach
</ul>
