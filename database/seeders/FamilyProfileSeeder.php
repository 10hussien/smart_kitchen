<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\FamilyProfile;

class FamilyProfileSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            FamilyProfile::create([
                'user_id' => $user->id,
                'number_of_people' => rand(1, 7),
            ]);
        }
    }
}
