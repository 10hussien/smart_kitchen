<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // هنا تضيف الـ Seeders التي تريد تشغيلها
        $this->call([
            UserSeeder::class,
        ]);
    }
}
