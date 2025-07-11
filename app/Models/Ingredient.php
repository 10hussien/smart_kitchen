<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_url',
        'name',
        'unit',
    ];

    public function aliases()
    {
        return $this->hasMany(IngredientAlias::class);
    }
}
