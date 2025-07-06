<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Login gagal. Periksa kembali email dan password.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function show() {
        $user = Auth::user();
        $userRecipes = Recipe::where('user_id', $user->id)->orderByDesc('created_at')->get();
        $isOwnProfile = true;
        return view('profile', compact('user', 'userRecipes', 'isOwnProfile'));
    }

    public function showUser(User $user) {
        $userRecipes = Recipe::where('user_id', $user->id)->orderByDesc('created_at')->get();
        $isOwnProfile = Auth::check() && Auth::id() == $user->id;
        return view('profile', compact('user', 'userRecipes', 'isOwnProfile'));
    }
    
    public function updatePhoto(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $photoPath = $request->file('photo')->store('user_photos', 'public');
        $user->photo_path = $photoPath;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diupdate!');
    }
}