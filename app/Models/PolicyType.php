<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'base_premium',
        'coverage_details',
    ];

    public function policies()
    {
        return $this->hasMany(InsurancePolicy::class);
    }
}
