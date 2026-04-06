<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;


// 1. main page
Route::get('/', function () {
    return view('home'); 
});

// 2. menu page
Route::get('/menu', function () {
    $products = Product::all(); //
    return view('menu', compact('products'));
});
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

