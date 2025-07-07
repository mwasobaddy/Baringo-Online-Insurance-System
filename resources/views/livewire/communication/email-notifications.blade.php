<?php
use Livewire\Volt\Component;

new class extends Component {
    public array $notifications = [];
    public bool $sent = false;

    public function sendEmailNotification(): void
    {
        // Simulate sending an email notification
        $this->sent = true;
    }
};
?>

<div>
    <h2 class="text-lg font-bold mb-4">Email Notifications (Simulation)</h2>
    <button wire:click="sendEmailNotification" class="px-4 py-2 bg-blue-600 text-white rounded">Send Test Email Notification</button>
    @if($sent)
        <div class="mt-4 p-3 bg-green-100 text-green-800 rounded">Email notification sent (simulated).</div>
    @endif
</div>
