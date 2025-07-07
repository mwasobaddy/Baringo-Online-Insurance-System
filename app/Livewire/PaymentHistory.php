<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class PaymentHistory extends Component
{
    public $payments = [];

    public function mount()
    {
        $this->payments = Payment::where('user_id', Auth::id())
            ->orderByDesc('paid_at')
            ->get();
    }
}
