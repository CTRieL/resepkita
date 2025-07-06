<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('q');
        $recipesQuery = Recipe::query()
            ->where('privacy', 'public')
            ->withCount('likes')
            ->orderByDesc('created_at');

        if ($query) {
            $recipesQuery->where(function($q) use ($query) {
                $q->where('title', 'like', "%$query%")
                  ->orWhere('ingredients', 'like', "%$query%")
                  ->orWhere('description', 'like', "%$query%")
                  ;
            });
        }
        $user = Auth::user();
        $recipes = $recipesQuery->paginate(10)->withQueryString();
        // Mark liked_by_user for each recipe
        if ($user) {
            $likedIds = $user->likes()->whereIn('recipe_id', $recipes->pluck('id'))->pluck('recipe_id')->toArray();
            foreach ($recipes as $recipe) {
                $recipe->liked_by_user = in_array($recipe->id, $likedIds);
            }
        }
        return view('dashboard', compact('recipes'));
    }
}
