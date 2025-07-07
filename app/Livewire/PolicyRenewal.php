<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Rule};
use App\Models\InsurancePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

#[Layout('layouts.app')]
class PolicyRenewal extends Component
{
    public $policies = [];
    public $selectedPolicyId = '';
    public $renewalDate = '';
    public $premiumAmount = '';

    public function mount()
    {
        $this->policies = InsurancePolicy::where('user_id', Auth::id())
            ->where('status', 'active')
            ->get();
    }

    public function selectPolicy($policyId)
    {
        $policy = InsurancePolicy::findOrFail($policyId);
        $this->selectedPolicyId = $policy->id;
        $this->renewalDate = $policy->end_date;
        $this->premiumAmount = $policy->premium_amount;
    }

    public function renew()
    {
        $this->validate([
            'selectedPolicyId' => 'required|exists:insurance_policies,id',
            'renewalDate' => 'required|date|after:today',
        ]);
        DB::beginTransaction();
        try {
            $policy = InsurancePolicy::findOrFail($this->selectedPolicyId);
            $policy->update([
                'end_date' => $this->renewalDate,
                'premium_amount' => $this->premiumAmount, // Should recalculate if needed
                'status' => 'active',
            ]);
            DB::commit();
            session()->flash('success', 'Policy renewed successfully.');
            $this->resetForm();
            $this->mount();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Policy renewal failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to renew policy. Please try again.');
        }
    }

    private function resetForm()
    {
        $this->selectedPolicyId = '';
        $this->renewalDate = '';
        $this->premiumAmount = '';
    }
}
