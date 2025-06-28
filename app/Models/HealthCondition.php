<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCondition extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_approved'
    ];

    public function familyProfiles()
    {
        return $this->belongsToMany(FamilyProfile::class, 'family_health_conditions');
    }
}
