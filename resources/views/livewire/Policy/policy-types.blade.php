<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Rule};
use App\Models\PolicyType;
use Illuminate\Support\Facades\Log;
use Exception;

#[Layout('layouts.app')]
class PolicyTypes extends Component
{
    public $policyTypes = [];
    #[Rule('required|string|max:255')]
    public $name = '';
    #[Rule('nullable|string')]
    public $description = '';
    #[Rule('required|numeric|min:0')]
    public $base_premium = '';
    #[Rule('nullable|string')]
    public $coverage_details = '';
    public $editingId = null;

    public function mount()
    {
        $this->loadPolicyTypes();
    }

    public function loadPolicyTypes()
    {
        $this->policyTypes = PolicyType::all();
    }

    public function save()
    {
        $this->validate();
        try {
            if ($this->editingId) {
                $type = PolicyType::findOrFail($this->editingId);
                $type->update($this->getFormData());
            } else {
                PolicyType::create($this->getFormData());
            }
            $this->resetForm();
            $this->loadPolicyTypes();
            session()->flash('success', 'Policy type saved successfully.');
        } catch (Exception $e) {
            Log::error('Policy type save failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to save policy type.');
        }
    }

    public function edit($id)
    {
        $type = PolicyType::findOrFail($id);
        $this->editingId = $type->id;
        $this->name = $type->name;
        $this->description = $type->description;
        $this->base_premium = $type->base_premium;
        $this->coverage_details = $type->coverage_details;
    }

    public function delete($id)
    {
        try {
            PolicyType::destroy($id);
            $this->loadPolicyTypes();
            session()->flash('success', 'Policy type deleted.');
        } catch (Exception $e) {
            Log::error('Policy type delete failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete policy type.');
        }
    }

    private function getFormData()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'base_premium' => $this->base_premium,
            'coverage_details' => $this->coverage_details,
        ];
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->description = '';
        $this->base_premium = '';
        $this->coverage_details = '';
    }
}
?>

<form wire:submit="save">
    <label for="name">Name</label>
    <input type="text" wire:model="name" id="name" required>
    <label for="description">Description</label>
    <input type="text" wire:model="description" id="description">
    <label for="base_premium">Base Premium</label>
    <input type="number" wire:model="base_premium" id="base_premium" required min="0">
    <label for="coverage_details">Coverage Details</label>
    <input type="text" wire:model="coverage_details" id="coverage_details">
    <button type="submit">Save</button>
</form>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<!-- List of Policy Types -->
<ul>
    @foreach($policyTypes as $type)
        <li>{{ $type->name }} (KES {{ $type->base_premium }})</li>
    @endforeach
</ul>
