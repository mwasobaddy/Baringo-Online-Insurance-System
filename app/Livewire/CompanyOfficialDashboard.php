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
