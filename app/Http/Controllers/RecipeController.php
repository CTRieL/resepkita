<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recipe.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'privacy' => 'required|in:private,public',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'directions' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,webp,png|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('recipe_photos', 'public');
        }

        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'privacy' => $validated['privacy'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'ingredients' => $validated['ingredients'],
            'directions' => $validated['directions'],
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('profile')->with('success', 'Resep berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        $comments = Comment::with('user')
            ->where('recipe_id', $recipe->id)
            ->latest()
            ->paginate(10);
        return view('recipe.show', compact('recipe', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        $user = Auth::user();
        if (!$user || $user->id != $recipe->user_id) {
            abort(403, 'Unauthorized');
        }
        return view('recipe.edit', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        $user = Auth::user();
        if (!$user || $user->id != $recipe->user_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'privacy' => 'required|in:private,public',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'directions' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,webp,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('recipe_photos', 'public');
            $recipe->photo_path = $photoPath;
        }

        $recipe->privacy = $validated['privacy'];
        $recipe->title = $validated['title'];
        $recipe->description = $validated['description'];    
        $recipe->ingredients = $validated['ingredients'];
        $recipe->directions = $validated['directions'];
        $recipe->save();

        return redirect()->route('profile')->with('success', 'Resep berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $user = Auth::user();
        if (!$user || $user->id != $recipe->user_id) {
            abort(403, 'Unauthorized');
        }

        // Hapus semua like & comment resep ini
        $recipe->likes()->delete();
        $recipe->comments()->delete();

        // Hapus foto jika ada
        if ($recipe->photo_path && Storage::disk('public')->exists($recipe->photo_path)) {
            Storage::disk('public')->delete($recipe->photo_path);
        }

        $recipe->delete();
        return redirect()->route('profile')->with('success', 'Resep berhasil dihapus!');
    }
}