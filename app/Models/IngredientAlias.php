<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientAlias extends Model
{
    use HasFactory;
    protected $fillable = [
        'ingredient_id',
        'alias_name'
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
