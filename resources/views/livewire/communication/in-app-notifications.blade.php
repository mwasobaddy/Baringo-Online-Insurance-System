<?php
use Livewire\Volt\Component;

new class extends Component {
    public array $notifications = [
        ['message' => 'Your policy has been approved!', 'read' => false],
        ['message' => 'Payment received for Policy #12345', 'read' => false],
    ];

    public function markAsRead(int $index): void
    {
        $this->notifications[$index]['read'] = true;
    }
};
?>

<div>
    <h2 class="text-lg font-bold mb-4">In-App Notifications (Simulation)</h2>
    <ul>
        @foreach($notifications as $i => $note)
            <li class="mb-2 p-2 border rounded {{ $note['read'] ? 'bg-gray-200' : 'bg-yellow-100' }}">
                {{ $note['message'] }}
                @if(!$note['read'])
                    <button wire:click="markAsRead({{ $i }})" class="ml-2 px-2 py-1 bg-blue-500 text-white rounded">Mark as Read</button>
                @endif
            </li>
        @endforeach
    </ul>
</div>
