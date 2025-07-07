<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Rule};
use App\Models\PolicyType;
use App\Models\InsurancePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

#[Layout('layouts.app')]
class PolicyApplication extends Component
{
    #[Rule('required|exists:policy_types,id')]
    public $policy_type_id = '';

    #[Rule('required|date')]
    public $start_date = '';

    #[Rule('required|numeric|min:0')]
    public $coverage_amount = '';

    public $step = 1;
    public $policyTypes = [];

    public function mount()
    {
        $this->policyTypes = PolicyType::all();
    }

    public function nextStep()
    {
        $this->validateOnlyCurrentStep();
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function submit()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $policy = InsurancePolicy::create([
                'user_id' => Auth::id(),
                'policy_type_id' => $this->policy_type_id,
                'policy_number' => uniqid('POL'),
                'status' => 'pending',
                'start_date' => $this->start_date,
                'end_date' => now()->parse($this->start_date)->addYear(),
                'premium_amount' => 0, // To be calculated
                'coverage_amount' => $this->coverage_amount,
            ]);
            DB::commit();
            session()->flash('success', 'Policy application submitted successfully.');
            return redirect()->route('policy-list');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Policy application failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to submit policy application. Please try again.');
        }
    }

    private function validateOnlyCurrentStep()
    {
        // Add step-based validation if needed
        $this->validate();
    }
}
?>

<form wire:submit="submit">
    <!-- Step 1: Select Policy Type -->
    <div x-show="step === 1">
        <label for="policy_type_id">Policy Type</label>
        <select wire:model="policy_type_id" id="policy_type_id" required>
            <option value="">Select Type</option>
            @foreach($policyTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
        <button type="button" wire:click="nextStep">Next</button>
    </div>
    <!-- Step 2: Enter Details -->
    <div x-show="step === 2">
        <label for="start_date">Start Date</label>
        <input type="date" wire:model="start_date" id="start_date" required>
        <label for="coverage_amount">Coverage Amount</label>
        <input type="number" wire:model="coverage_amount" id="coverage_amount" required min="0">
        <button type="button" wire:click="previousStep">Back</button>
        <button type="submit">Submit</button>
    </div>
</form>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
