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