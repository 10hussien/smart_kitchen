<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FridgeItem;
use App\Models\Ingredient;
use App\Models\FamilyProfile;
use Carbon\Carbon;

class FridgeItemSeeder extends Seeder
{
    public function run(): void
    {
        $perishableIngredients = [
            'البندورة',
            'الخيار',
            'البازيلاء',
            'العدس',
            'الحليب',
            'البيض',
            'اللبن',
            'اللحم',
            'الدجاج',
            'العنب',
            'التفاح',
            'الموز',
            'الجبن',
            'البطيخ',
            'الجزر',
            'القرنبيط',
            'السمك'
        ];

        $ingredients = Ingredient::all();
        $familyProfiles = FamilyProfile::all();

        foreach ($familyProfiles as $profile) {
            $count = rand(5, 10); // عدد العناصر في البراد
            $usedIngredientIds = [];

            for ($i = 0; $i < $count; $i++) {
                $ingredient = $ingredients->random();

                // تجنب التكرار في البراد
                if (in_array($ingredient->id, $usedIngredientIds)) continue;
                $usedIngredientIds[] = $ingredient->id;

                // عشوائيًا: هل المكون له تاريخ صلاحية؟
                $hasExpiry = in_array($ingredient->name, $perishableIngredients);
                $expirationDate = $hasExpiry
                    ? Carbon::today()->addDays(rand(-3, 10))->toDateString()
                    : null;

                FridgeItem::create([
                    'family_profile_id' => $profile->id,
                    'ingredient_id' => $ingredient->id,
                    'quantity' => rand(1, 5) . ' ' . $ingredient->unit,
                    'expiration_date' => $expirationDate,
                ]);
            }
        }
    }
}
