<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

// --- 1. ХЭРЭГЛЭГЧИЙН ХЭСЭГ (GUEST/USER) ---

// Нүүр хуудас
Route::get('/', function () {
    return view('home'); 
})->name('home');

// Цэсний хуудас - Controller-оор дамжуулж өгөгдөл авах нь зөв
Route::get('/menu', [ProductController::class, 'index'])->name('menu');


// --- 2. БҮРТГЭЛ, НЭВТРЭХ ХЭСЭГ (AUTH) ---

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


// --- 3. АДМИН ХЭСЭГ (ADMIN DASHBOARD) ---

Route::prefix('admin')->group(function () {
    // Админ самбар харах
    Route::get('/dashboard', [ProductController::class, 'adminIndex'])->name('admin.dashboard');
    
    // Хоол нэмэх (URL: /admin/add-product)
    Route::post('/add-product', [ProductController::class, 'store'])->name('product.store');
    
    // Хоол устгах (URL: /admin/delete-product/{id})
    Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
});