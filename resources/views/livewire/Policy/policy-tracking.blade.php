<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\InsurancePolicy;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class PolicyTracking extends Component
{
    public $policies = [];

    public function mount()
    {
        $this->policies = InsurancePolicy::where('user_id', Auth::id())
            ->with(['policyType'])
            ->orderByDesc('created_at')
            ->get();
    }
}
?>

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
