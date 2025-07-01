<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FridgeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_profile_id',
        'ingredient_id',
        'quantity',
        'expiration_date',
    ];

    public function familyProfile()
    {
        return $this->belongsTo(FamilyProfile::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
