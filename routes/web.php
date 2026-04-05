<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

<<<<<<< HEAD
// 1. main page
Route::get('/', function () {
    return view('home'); 
});

// 2. menu page
Route::get('/menu', function () {
    $products = Product::all(); //
    return view('menu', compact('products'));
});
=======
Route::get('/', function () {
    $products = Product::all(); // Бүх хоолыг сангаас авах
    return view('welcome', compact('products'));
});
>>>>>>> 09431e5d47089063e875b6a675897d8be7c6cf70
