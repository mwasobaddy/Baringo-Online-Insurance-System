<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\InsurancePolicy;
use App\Models\User;
use App\Models\Claim;

#[Layout('layouts.app')]
class AdminDashboard extends Component
{
    public $pendingApprovals = [];
    public $users = [];
    public $claims = [];

    public function mount()
    {
        $this->pendingApprovals = InsurancePolicy::where('status', 'pending')->with('user', 'policyType')->get();
        $this->users = User::all();
        $this->claims = Claim::with('user', 'policy')->orderByDesc('created_at')->get();
    }
}
?>

<div>
    <h2 class="text-lg font-bold mb-4">Admin Dashboard</h2>
    <h3>Pending Approvals</h3>
    <ul>
        @foreach($pendingApprovals as $policy)
            <li>Policy #: {{ $policy->policy_number }} ({{ $policy->user->name ?? 'N/A' }})</li>
        @endforeach
    </ul>
    <h3>Users</h3>
    <ul>
        @foreach($users as $user)
            <li>{{ $user->name }} ({{ $user->email }})</li>
        @endforeach
    </ul>
    <h3>Claims</h3>
    <ul>
        @foreach($claims as $claim)
            <li>Claim #: {{ $claim->id }} ({{ $claim->user->name ?? 'N/A' }})</li>
        @endforeach
    </ul>
</div>
