<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\InsurancePolicy;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

#[Layout('layouts.app')]
class PaymentForm extends Component
{
    public $policies = [];
    public $policy_id = '';
    public $amount = '';
    public $payment_method = '';
    public $status = '';
    public $transaction_id = '';

    public function mount()
    {
        $this->policies = InsurancePolicy::where('user_id', Auth::id())->get();
    }

    public function submit()
    {
        $this->validate([
            'policy_id' => 'required|exists:insurance_policies,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);
        try {
            // Simulate payment processing
            $this->transaction_id = uniqid('TXN');
            $this->status = 'success';
            Payment::create([
                'user_id' => Auth::id(),
                'policy_id' => $this->policy_id,
                'amount' => $this->amount,
                'payment_method' => $this->payment_method,
                'transaction_id' => $this->transaction_id,
                'status' => $this->status,
                'paid_at' => now(),
            ]);
            session()->flash('success', 'Payment simulated and recorded successfully.');
            $this->resetForm();
        } catch (Exception $e) {
            Log::error('Payment simulation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to simulate payment.');
        }
    }

    private function resetForm()
    {
        $this->policy_id = '';
        $this->amount = '';
        $this->payment_method = '';
        $this->transaction_id = '';
        $this->status = '';
    }
}
?>

<form wire:submit="processPayment">
    <label for="policy_id">Select Policy</label>
    <select wire:model="policy_id" id="policy_id" required>
        <option value="">Select Policy</option>
        @foreach($policies as $policy)
            <option value="{{ $policy->id }}">{{ $policy->policy_number }}</option>
        @endforeach
    </select>
    <label for="amount">Amount</label>
    <input type="number" wire:model="amount" id="amount" required min="0">
    <label for="payment_method">Payment Method</label>
    <select wire:model="payment_method" id="payment_method" required>
        <option value="">Select Method</option>
        <option value="mpesa">M-Pesa (Simulation)</option>
        <option value="airtel">Airtel Money (Simulation)</option>
        <option value="card">Card (Simulation)</option>
    </select>
    <button type="submit">Pay</button>
</form>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
