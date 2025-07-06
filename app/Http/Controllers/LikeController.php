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
        // Cek apakah user sudah like tipe yang sama kalau sama hapus
        $existing = Like::where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->where('type', $validated['type'])
            ->first();
        try {
            if ($existing) {
                Like::where('user_id', $userId)
                    ->where('recipe_id', $recipeId)
                    ->where('type', $validated['type'])
                    ->delete();
                $likedType = null;
            } else {
                Like::where('user_id', $userId)
                    ->where('recipe_id', $recipeId)
                    ->delete();
                Like::create([
                    'user_id' => $userId,
                    'recipe_id' => $recipeId,
                    'type' => $validated['type'],
                ]);
                $likedType = $validated['type'];
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }

        // Hitung jumlah like per tipe
        $likeCounts = [
            'thumbs_up' => Like::where('recipe_id', $recipeId)->where('type', 'thumbs_up')->count(),
            'love' => Like::where('recipe_id', $recipeId)->where('type', 'love')->count(),
            'tasty' => Like::where('recipe_id', $recipeId)->where('type', 'tasty')->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Like updated',
            'liked_type' => $likedType,
            'like_counts' => $likeCounts,
        ]);
    }
}
