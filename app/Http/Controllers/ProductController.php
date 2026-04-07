<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('menu', compact('products'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'image' => 'required'
        ]);

        Product::create($request->all());
        return back()->with('success', 'Хоол амжилттай нэмэгдлээ!');
    }

    public function destroy($id) {
        Product::destroy($id);
        return back();
    }

public function adminIndex() {
    $products = Product::all();
    return view('admin.dashboard', compact('products')); // Админ хуудас
}
}