<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\InsurancePolicy;
use App\Models\User;
use App\Models\Claim;

#[Layout('layouts.app')]
class CompanyOfficialDashboard extends Component
{
    public $pendingPolicies = [];
    public $clients = [];
    public $claims = [];

    public function mount()
    {
        $this->pendingPolicies = InsurancePolicy::where('status', 'pending')->with('user', 'policyType')->get();
        $this->clients = User::role('policy_holder')->get();
        $this->claims = Claim::with('user', 'policy')->orderByDesc('created_at')->get();
    }
}
?>

<div>
    <h2 class="text-lg font-bold mb-4">Company Official Dashboard</h2>
    <h3>Pending Policies</h3>
    <ul>
        @foreach($pendingPolicies as $policy)
            <li>Policy #: {{ $policy->policy_number }} ({{ $policy->user->name ?? 'N/A' }})</li>
        @endforeach
    </ul>
    <h3>Clients</h3>
    <ul>
        @foreach($clients as $client)
            <li>{{ $client->name }} ({{ $client->email }})</li>
        @endforeach
    </ul>
    <h3>Claims</h3>
    <ul>
        @foreach($claims as $claim)
            <li>Claim #: {{ $claim->id }} ({{ $claim->user->name ?? 'N/A' }})</li>
        @endforeach
    </ul>
</div>
