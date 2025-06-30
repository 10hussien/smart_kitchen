<?php

// database/seeders/IngredientAliasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use App\Models\IngredientAlias;

class IngredientAliasSeeder extends Seeder
{
    public function run(): void
    {
        $aliases = [
            // [الاسم الأساسي في الجدول ingredients, الاسم البديل (alias)]
            ['البندورة', 'طماطم'],
            ['الأرز', 'رز'],
            ['البطيخ', 'جبس'],
            ['الجميد', 'كثي'],
            ['اللبن', 'زبادي'],
            ['الخبز', 'عيش'],
            ['البطاطا', 'بطاطس'],
            ['الكزبرة', 'قسبر'],
            ['الجزر', 'سنارية'],
            ['البازيلاء', 'بازيلا'],
            ['النعنع', 'نعناع'],
            ['البقدونس', 'معدنوس'],
            ['البيض', 'بيضة'],
            ['الفاصولياء', 'لوبيا'],
            ['الحمص', 'نخنة'],
            ['الثوم', 'توم'],
            ['البصل', 'بصلية'],
        ];

        foreach ($aliases as [$mainName, $aliasName]) {
            $ingredient = Ingredient::where('name', $mainName)->first();

            if ($ingredient) {
                // تأكد من عدم تكرار alias_name
                IngredientAlias::firstOrCreate(
                    ['alias_name' => $aliasName],
                    ['ingredient_id' => $ingredient->id]
                );
            }
        }
    }
}
