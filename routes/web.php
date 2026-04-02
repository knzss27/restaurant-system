<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::all(); // Бүх хоолыг сангаас авах
    return view('welcome', compact('products'));
});
