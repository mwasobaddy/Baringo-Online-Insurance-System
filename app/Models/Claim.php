<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'policy_id',
        'claim_number',
        'description',
        'amount_claimed',
        'status',
        'submitted_at',
        'processed_at',
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
