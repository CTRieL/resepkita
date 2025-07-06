<?php
namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition()
    {
        $filename = 'user_' . $this->faker->unique()->uuid . '.jpg';
        $sourceDummy = public_path('dummy/recipe_photos/' . rand(1, 10) . '.png'); // ambil random
        $storagePath = 'recipe_photos/' . $filename;

        // Salin dari public/dummy/recipe_photos ke storage/app/public/recipe_photos
        Storage::disk('public')->put($storagePath, file_get_contents($sourceDummy));

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'privacy' => $this->faker->randomElement(['private', 'public']),
            'title' => $this->faker->sentence(fake()->numberBetween(2, 9)),
            'description' => $this->faker->paragraph(),
            'ingredients' => $this->faker->sentences(fake()->numberBetween(1, 5), true),
            'directions' => $this->faker->paragraphs(fake()->numberBetween(2, 4), true),
            'photo_path' => 'recipe_photos/' . $filename,
        ];
    }
}