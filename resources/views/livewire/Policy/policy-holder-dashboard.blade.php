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
?>

<div>
    <h2 class="text-lg font-bold mb-4">Policy Holder Dashboard</h2>
    <h3>Your Policies</h3>
    <ul>
        @foreach($policies as $policy)
            <li>Policy #: {{ $policy->policy_number }} ({{ $policy->policyType->name ?? 'N/A' }})</li>
        @endforeach
    </ul>
    <h3>Your Payments</h3>
    <ul>
        @foreach($payments as $payment)
            <li>Amount: KES {{ number_format($payment->amount, 2) }} | Status: {{ ucfirst($payment->status) }}</li>
        @endforeach
    </ul>
</div>
