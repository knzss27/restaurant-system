<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartIds = array_keys($cart);
        $recommendations = Product::whereNotIn('id', $cartIds)->inRandomOrder()->take(8)->get();
        return view('cart', compact('cart', 'recommendations'));
    }

    // Нэр нь Route-тэй адилхан 'add' боллоо
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        if(isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Хоол сагсанд нэмэгдлээ!');
    }

    // Нэр нь 'remove'
    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        return response()->json(['success' => true]);
    }

    // Сагсны тоог шинэчлэх (Route дээр чинь 'update' нэртэй байгаа)
    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        return response()->json(['success' => true]);
    }
}