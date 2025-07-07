<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\PolicyType;

#[Layout('layouts.app')]
class PremiumCalculator extends Component
{
    public $policyTypes = [];
    public $policy_type_id = '';
    public $coverage_amount = '';
    public $calculated_premium = null;

    public function mount()
    {
        $this->policyTypes = PolicyType::all();
    }

    public function calculate()
    {
        $this->validate([
            'policy_type_id' => 'required|exists:policy_types,id',
            'coverage_amount' => 'required|numeric|min:1',
        ]);
        $type = PolicyType::find($this->policy_type_id);
        // Simulate premium calculation: base_premium + 2% of coverage
        $this->calculated_premium = $type->base_premium + (0.02 * $this->coverage_amount);
    }
}
?>

<form wire:submit="calculatePremium">
    <label for="policy_type_id">Policy Type</label>
    <select wire:model="policy_type_id" id="policy_type_id" required>
        <option value="">Select Type</option>
        @foreach($policyTypes as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
    </select>
    <label for="factors">Factors</label>
    <input type="text" wire:model="factors" id="factors" placeholder="e.g. age, location">
    <button type="submit">Calculate</button>
</form>
@if($premium)
    <div class="alert alert-info">Calculated Premium: KES {{ number_format($premium, 2) }}</div>
@endif
