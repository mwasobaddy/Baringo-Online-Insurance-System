<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Rule;

new class extends Component {
    #[Rule('required|string|max:500')]
    public string $feedback = '';
    public bool $submitted = false;

    public function submitFeedback(): void
    {
        $this->validate();
        // Simulate feedback submission
        $this->submitted = true;
        $this->feedback = '';
    }
};
?>

<div>
    <h2 class="text-lg font-bold mb-4">Feedback System (Simulation)</h2>
    <form wire:submit.prevent="submitFeedback" class="space-y-4">
        <textarea wire:model.defer="feedback" class="w-full p-2 border rounded" rows="4" placeholder="Enter your feedback..."></textarea>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Submit Feedback</button>
    </form>
    @if($submitted)
        <div class="mt-4 p-3 bg-green-100 text-green-800 rounded">Thank you for your feedback! (simulated)</div>
    @endif
</div>
