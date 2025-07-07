<?php
use Livewire\Volt\Component;

new class extends Component {
    public bool $sent = false;

    public function sendSms(): void
    {
        // Simulate sending an SMS
        $this->sent = true;
    }
};
?>

<div>
    <h2 class="text-lg font-bold mb-4">SMS Integration (Simulation)</h2>
    <button wire:click="sendSms" class="px-4 py-2 bg-blue-600 text-white rounded">Send Test SMS</button>
    @if($sent)
        <div class="mt-4 p-3 bg-green-100 text-green-800 rounded">SMS sent (simulated).</div>
    @endif
</div>
