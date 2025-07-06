<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Like;

class LikeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $recipes = Recipe::all();

        foreach ($users as $user) {
            $recipes->random( 35)->each(function ($recipe) use ($user) {
                Like::updateOrCreate(
                    ['user_id' => $user->id, 'recipe_id' => $recipe->id],
                    ['type' => fake()->randomElement(['thumbs_up', 'love', 'tasty'])]
                );
            });
        }
    }
}