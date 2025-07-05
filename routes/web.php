<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/404', function () {
    return view('errors.404');
});

// Route::fallback(function () {
//     return response()->view('errors.404', [], 404);
// });