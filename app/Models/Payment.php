<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'policy_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'paid_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function policy()
    {
        return $this->belongsTo(InsurancePolicy::class, 'policy_id');
    }
}
