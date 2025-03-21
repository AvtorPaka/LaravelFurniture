<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FurnitureGood;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admn@gmail.com',
            'password' => '12345'
        ]);
        $admin->assignRole('admin');

        Category::factory()
            ->count(10)
            ->sequence(fn($sequence) => ['parent_category_id' => null])
            ->create();

        Category::factory()
            ->count(20)
            ->create();

        FurnitureGood::factory()
            ->count(100)
            ->create();
    }
}
