<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();

        return view('menu', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string',
            'image' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if (empty($validated['category_id']) && ! empty($validated['category'])) {
            $categoryIds = ['bagts' => 1, 'pizza' => 2, 'burger' => 3, 'undaa' => 4, 'nemelt' => 5];
            $validated['category_id'] = $categoryIds[$validated['category']] ?? null;
        }

        unset($validated['category']);

        Product::create($validated);

        return back()->with('success', 'Хоол амжилттай нэмэгдлээ!');
    }

    public function destroy($id)
    {
        Product::destroy($id);

        return back();
    }

    public function adminIndex()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();

        return view('admin.dashboard', compact('products', 'categories'));
    }
}
