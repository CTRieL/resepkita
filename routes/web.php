<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('landing');
// })->name('landing');

Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home');
    });


    Route::resource('/recipe', RecipeController::class);
    Route::post('/recipe/{recipe}/comment', [CommentController::class, 'store'])->name('comment.store');

    Route::post('/recipe/{recipe}/like', [LikeController::class, 'like'])->name('recipe.like');

    Route::get('/profile', [AuthController::class, 'show'])->name('profile');
    Route::get('/profile/{user}', [AuthController::class, 'showUser'])->name('profile.user');
    Route::post('/profile/photo', [AuthController::class, 'updatePhoto'])->name('profile.photo');

    Route::get('/dashboard', App\Http\Controllers\DashboardController::class)->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});