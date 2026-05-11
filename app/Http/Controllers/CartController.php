<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Сагсанд байгаа хоолнуудыг харах
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartIds = array_keys($cart);
        $recommendations = Product::whereNotIn('id', $cartIds)->inRandomOrder()->take(8)->get();
        return view('cart', compact('cart', 'recommendations'));
    }

    // Сагсанд хоол нэмэх
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Формоос ирсэн тоог авна (байхгүй бол 1)
        $quantity = $request->input('quantity', 1);

        // Хэрэв сагсанд энэ хоол аль хэдийн байвал тоог нь нэмнэ
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Байхгүй бол шинээр нэмнэ
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        // Glitch-ээс сэргийлж, буцахдаа одоогийн секшнийг нь хамт дамжуулна
        return redirect()->back()->with('success', 'Хоол сагсанд нэмэгдлээ!');
    }

    // Сагснаас хоол хасах
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Хоол сагснаас хасагдлаа');
        }
    }
}