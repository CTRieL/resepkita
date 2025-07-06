<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('user_photos');
        Storage::disk('public')->deleteDirectory('recipe_photos');
        Storage::disk('public')->makeDirectory('user_photos');
        Storage::disk('public')->makeDirectory('recipe_photos');

        $this->call([
            UserSeeder::class,
            RecipeSeeder::class,
            CommentSeeder::class,
            LikeSeeder::class,
        ]);
    }
}