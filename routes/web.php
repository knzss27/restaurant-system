<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::post('/login', [AuthController::class, 'login']); // Энэ замыг нэмэх шаардлагатай

Route::post('/register', [AuthController::class, 'register'])->name('register.post');