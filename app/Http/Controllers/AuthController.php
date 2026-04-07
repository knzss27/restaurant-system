<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. НЭМЭХ ХЭСЭГ: Логин хуудсыг харуулах (GET хүсэлтэд зориулсан)
    public function showLogin()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php файл байгаа эсэхийг шалгаарай
    }

    // 2. НЭМЭХ ХЭСЭГ: Бүртгэлийн хуудсыг харуулах (GET хүсэлтэд зориулсан)
    public function showRegister()
    {
        return view('register'); // resources/views/register.blade.php файл байгаа эсэхийг шалгаарай
    }

    // Нэвтрэх (Login) үйлдэл боловсруулах
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Нэвтэрсний дараа menu хуудас руу шилжүүлнэ
            return redirect()->intended('menu');
        }

        return back()->withErrors(['email' => 'Имэйл эсвэл нууц үг буруу байна']);
    }

    // Бүртгүүлэх (Register) үйлдэл боловсруулах
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
            'phone' => $request->phone, 
            'password' => Hash::make($request->password),
        ]);

        // 3. Амжилттай болбол логин руу шилжүүлэх
        return redirect()->route('login')->with('success', 'Амжилттай бүртгүүллээ!');
    }

    // 3. НЭМЭХ ХЭСЭГ: Гарах (Logout)
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/menu');
    }
}