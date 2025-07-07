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
