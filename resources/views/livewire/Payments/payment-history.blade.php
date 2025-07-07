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
?>

<ul>
    @foreach($payments as $payment)
        <li>
            Policy #: {{ $payment->policy->policy_number ?? 'N/A' }}<br>
            Amount: KES {{ number_format($payment->amount, 2) }}<br>
            Method: {{ ucfirst($payment->payment_method) }}<br>
            Status: {{ ucfirst($payment->status) }}<br>
            Paid At: {{ $payment->paid_at }}
        </li>
    @endforeach
</ul>
