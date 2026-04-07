<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Нэвтрэх (Login) функц
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('menu');
        }

        return back()->withErrors(['email' => 'Мэдээлэл буруу байна']);
    }

    // Бүртгүүлэх (Register) функц
    public function register(Request $request)
    {
        // 1. Validation (Шалгалт)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required', 
        ]);

        // 2. Өгөгдлийн санд хадгалах
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, // Database-д phone багана байгаа эсэхийг шалгаарай
            'password' => Hash::make($request->password),
        ]);

        // 3. Бүртгүүлсний дараа шууд нэвтрүүлэх эсвэл логин руу шилжүүлэх
        return redirect()->route('login')->with('success', 'Амжилттай бүртгүүллээ!');
    }
}