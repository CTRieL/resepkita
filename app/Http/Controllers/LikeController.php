<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController
{
    /**
     * Store like. if like already stored, delete it.
     */
    public function like(Request $request, $recipeId)
    {
        $validated = $request->validate([
            'type' => 'required|in:thumbs_up,love,tasty',
        ]);

        $userId = Auth::id();
        $existing = Like::where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->where('type', $validated['type'])
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success' => true,
                'message' => 'Like dihapus!',
                'liked' => false
            ]);
            
        } else {
            $like = Like::create([
                'user_id' => $userId,
                'recipe_id' => $recipeId,
                'type' => $validated['type'],
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Like berhasil ditambahkan!',
                'like' => $like,
                'liked' => true
            ]);
        }
    }
}
