<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Recipe;
use App\Models\User;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $recipes = Recipe::all();

        foreach ($users as $user) {
            // setiap user akan comment 20 resep secara acak
            $recipes->random(rand(1, 25))->each(function ($recipe) use ($user) {
                Comment::updateOrCreate(
                    ['user_id' => $user->id, 'recipe_id' => $recipe->id],
                    ['message' => fake()->sentence(fake()->numberBetween(2, 16))]
                );
            });
        }
    }
}