<?php
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Rule};
use App\Models\Payment;
use Illuminate\Support\Carbon;

new class extends Component {
    public array $reminders = [];
    public bool $reminderSent = false;
    public ?int $selectedPaymentId = null;

    public function mount(): void
    {
        // Simulate fetching upcoming and overdue payments for the logged-in user
        $this->reminders = Payment::query()
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'overdue'])
            ->orderBy('paid_at', 'asc')
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'policy_number' => optional($payment->policy)->policy_number,
                    'amount' => $payment->amount,
                    'due_date' => $payment->paid_at ? Carbon::parse($payment->paid_at)->toDateString() : 'N/A',
                    'status' => $payment->status,
                ];
            })->toArray();
    }

    public function sendReminder(int $paymentId): void
    {
        // Simulate sending a reminder (no real email/SMS)
        $this->reminderSent = true;
        $this->selectedPaymentId = $paymentId;
        // In a real system, you would dispatch a job or event here
    }
};
?>

<div>
    <h2 class="text-lg font-bold mb-4">Payment Reminders (Simulation)</h2>
    <div class="space-y-4">
        @forelse($reminders as $reminder)
            <div class="p-4 border rounded flex items-center justify-between bg-yellow-50">
                <div>
                    <div class="font-semibold">Policy #: {{ $reminder['policy_number'] ?? 'N/A' }}</div>
                    <div>Amount: KES {{ number_format($reminder['amount'], 2) }}</div>
                    <div>Due Date: {{ $reminder['due_date'] }}</div>
                    <div>Status: <span class="text-red-600">{{ ucfirst($reminder['status']) }}</span></div>
                </div>
                <button wire:click="sendReminder({{ $reminder['id'] }})" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Send Reminder</button>
            </div>
        @empty
            <div class="text-gray-500">No pending or overdue payments found.</div>
        @endforelse
    </div>
    @if($reminderSent)
        <div class="mt-4 p-3 bg-green-100 text-green-800 rounded">
            Reminder sent (simulated) for payment ID: {{ $selectedPaymentId }}
        </div>
    @endif
</div>
