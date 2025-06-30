<?php

// database/seeders/IngredientSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => 'البندورة', 'unit' => 'كيلو', 'image_url' => 'images/tomato.png'],
            ['name' => 'الخيار', 'unit' => 'كيلو', 'image_url' => 'images/cucumber.png'],
            ['name' => 'البازيلاء', 'unit' => 'كيلو', 'image_url' => 'images/peas.png'],
            ['name' => 'العدس', 'unit' => 'كيلو', 'image_url' => 'images/lentils.png'],
            ['name' => 'الأرز', 'unit' => 'كيلو', 'image_url' => 'images/rice.png'],
            ['name' => 'الزيت', 'unit' => 'لتر', 'image_url' => 'images/oil.png'],
            ['name' => 'الملح', 'unit' => 'غرام', 'image_url' => 'images/salt.png'],
            ['name' => 'السكر', 'unit' => 'كيلو', 'image_url' => 'images/sugar.png'],
            ['name' => 'الخبز', 'unit' => 'رغيف', 'image_url' => 'images/bread.png'],
            ['name' => 'الطحين', 'unit' => 'كيلو', 'image_url' => 'images/flour.png'],

            ['name' => 'البيض', 'unit' => 'حبة', 'image_url' => 'images/egg.png'],
            ['name' => 'الجبن', 'unit' => 'غرام', 'image_url' => 'images/cheese.png'],
            ['name' => 'الحليب', 'unit' => 'لتر', 'image_url' => 'images/milk.png'],
            ['name' => 'اللبن', 'unit' => 'كوب', 'image_url' => 'images/yogurt.png'],
            ['name' => 'الفاصولياء', 'unit' => 'كيلو', 'image_url' => 'images/beans.png'],
            ['name' => 'الحمص', 'unit' => 'كيلو', 'image_url' => 'images/chickpeas.png'],
            ['name' => 'الثوم', 'unit' => 'رأس', 'image_url' => 'images/garlic.png'],
            ['name' => 'البصل', 'unit' => 'كيلو', 'image_url' => 'images/onion.png'],
            ['name' => 'النعنع', 'unit' => '束', 'image_url' => 'images/mint.png'],
            ['name' => 'البقدونس', 'unit' => '束', 'image_url' => 'images/parsley.png'],

            ['name' => 'الجميد', 'unit' => 'قطعة', 'image_url' => 'images/jameed.png'],
            ['name' => 'الزعتر', 'unit' => 'علبة', 'image_url' => 'images/thyme.png'],
            ['name' => 'الفلفل الأسود', 'unit' => 'غرام', 'image_url' => 'images/black-pepper.png'],
            ['name' => 'الكركم', 'unit' => 'غرام', 'image_url' => 'images/turmeric.png'],
            ['name' => 'الزنجبيل', 'unit' => 'غرام', 'image_url' => 'images/ginger.png'],
            ['name' => 'القرفة', 'unit' => 'غرام', 'image_url' => 'images/cinnamon.png'],
            ['name' => 'الهيل', 'unit' => 'غرام', 'image_url' => 'images/cardamom.png'],
            ['name' => 'القرنفل', 'unit' => 'غرام', 'image_url' => 'images/clove.png'],
            ['name' => 'الكمون', 'unit' => 'غرام', 'image_url' => 'images/cumin.png'],
            ['name' => 'السمك', 'unit' => 'كيلو', 'image_url' => 'images/fish.png'],

            ['name' => 'اللحم', 'unit' => 'كيلو', 'image_url' => 'images/meat.png'],
            ['name' => 'الدجاج', 'unit' => 'حبة', 'image_url' => 'images/chicken.png'],
            ['name' => 'البطيخ', 'unit' => 'حبة', 'image_url' => 'images/watermelon.png'],
            ['name' => 'العنب', 'unit' => 'كيلو', 'image_url' => 'images/grape.png'],
            ['name' => 'الموز', 'unit' => 'كيلو', 'image_url' => 'images/banana.png'],
            ['name' => 'التفاح', 'unit' => 'كيلو', 'image_url' => 'images/apple.png'],
            ['name' => 'البرتقال', 'unit' => 'كيلو', 'image_url' => 'images/orange.png'],
            ['name' => 'الجزر', 'unit' => 'كيلو', 'image_url' => 'images/carrot.png'],
            ['name' => 'القرنبيط', 'unit' => 'رأس', 'image_url' => 'images/cauliflower.png'],
        ];

        foreach ($ingredients as $item) {
            Ingredient::create($item);
        }
    }
}
