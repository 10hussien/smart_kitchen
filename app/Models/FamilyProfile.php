<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'number_of_people'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function healthConditions()
    {
        return $this->belongsToMany(HealthCondition::class, 'family_health_conditions');
    }
}
