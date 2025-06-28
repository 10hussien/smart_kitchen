<?php

namespace Database\Seeders;

use App\Models\HealthCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditions = [
            ['name' => 'Diabetes', 'is_approved' => true],
            ['name' => 'high blood pressure', 'is_approved' => true],
            ['name' => 'peanut allergy', 'is_approved' => true],
            ['name' => 'asthma', 'is_approved' => true],
            ['name' => 'Irritable bowel syndrome', 'is_approved' => true],
        ];

        foreach ($conditions as $condition) {
            HealthCondition::create($condition);
        }
    }
}
