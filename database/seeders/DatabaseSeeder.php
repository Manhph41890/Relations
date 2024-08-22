<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        for ($i = 0; $i < 10; $i++) {
            Category::query()->create([
                'name' => 'Danh muc' . $i
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            Tag::query()->create([
                'name' => 'Tag' . $i
            ]);
        }
    }
}