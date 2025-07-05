<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('dashboard')->with('success', 'Resep berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $resep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $resep)
    {
        $user = Auth::user();
        if (!$user || $user->id != $resep->user_id) {
            abort(403, 'Unauthorized');
        }
        return view('recipe.edit', compact('resep'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $resep)
    {
        $user = Auth::user();
        if (!$user || $user->id != $resep->user_id) {
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
            $resep->photo_path = $photoPath;
        }

        $resep->privacy = $validated['privacy'];
        $resep->title = $validated['title'];
        $resep->description = $validated['description'];    
        $resep->ingredients = $validated['ingredients'];
        $resep->directions = $validated['directions'];
        $resep->save();

        return redirect()->route('dashboard')->with('success', 'Resep berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $resep)
    {
        //
    }
}