<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\InsurancePolicy;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class PolicyHolderDashboard extends Component
{
    public $policies = [];
    public $payments = [];

    public function mount()
    {
        $userId = Auth::id();
        $this->policies = InsurancePolicy::where('user_id', $userId)->with('policyType')->get();
        $this->payments = Payment::where('user_id', $userId)->orderByDesc('paid_at')->get();
    }
}
