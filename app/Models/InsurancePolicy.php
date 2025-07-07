<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsurancePolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'policy_type_id',
        'policy_number',
        'status',
        'start_date',
        'end_date',
        'premium_amount',
        'coverage_amount',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function policyType()
    {
        return $this->belongsTo(PolicyType::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'policy_id');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class, 'policy_id');
    }
}
