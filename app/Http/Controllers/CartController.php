<?php

namespace App\Http\Controllers;

use App\Mail\OrderSuccessMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);
        $quantity = max(1, (int) $request->input('quantity', 1));

        session()->put('order_fulfillment', [
            'type' => $request->input('fulfillment_type', 'delivery'),
            'address' => $request->input('delivery_address'),
        ]);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => $this->cartCount($cart),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function remove(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cart_count' => $this->cartCount($cart),
        ]);
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = (int) $request->quantity;
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cart_count' => $this->cartCount($cart),
        ]);
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart', compact('cart'));
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $fulfillment = session()->get('order_fulfillment', [
            'type' => 'delivery',
            'address' => '',
        ]);

        return view('checkout', compact('cart', 'fulfillment'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required|in:card,qpay',
            'notes' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'delivery_address' => $request->delivery_address,
            'phone' => $request->phone,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        if (auth()->user()?->email) {
            Mail::to(auth()->user()->email)->send(new OrderSuccessMail($order));
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)->with('success', 'Order created successfully.');
    }

    public function qpayCreate(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $tokenRes = Http::withBasicAuth(
            config('services.qpay.username'),
            config('services.qpay.password')
        )->post('https://merchant.qpay.mn/v2/auth/token');

        $token = $tokenRes->json('access_token');

        $invoiceRes = Http::withToken($token)
            ->post('https://merchant.qpay.mn/v2/invoice', [
                'invoice_code' => config('services.qpay.invoice_code'),
                'sender_invoice_no' => 'ORDER-' . time(),
                'invoice_receiver_code' => 'terminal',
                'invoice_description' => 'Crust & Grill order',
                'amount' => $request->amount,
                'callback_url' => route('checkout.qpay.callback'),
            ]);

        $data = $invoiceRes->json();

        if (! isset($data['invoice_id'])) {
            return response()->json(['error' => 'QPay invoice could not be created.'], 500);
        }

        return response()->json([
            'invoice_id' => $data['invoice_id'],
            'qr_image' => $data['qr_image'],
        ]);
    }

    public function qpayCheck(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|string',
        ]);

        $tokenRes = Http::withBasicAuth(
            config('services.qpay.username'),
            config('services.qpay.password')
        )->post('https://merchant.qpay.mn/v2/auth/token');

        $token = $tokenRes->json('access_token');

        $result = Http::withToken($token)
            ->post('https://merchant.qpay.mn/v2/payment/check', [
                'object_type' => 'INVOICE',
                'object_id' => $request->invoice_id,
                'offset' => ['page_number' => 1, 'page_limit' => 1],
            ]);

        $data = $result->json();

        return response()->json([
            'paid' => isset($data['count']) && $data['count'] > 0,
        ]);
    }

    public function qpayCallback(Request $request)
    {
        return response()->json(['status' => 'ok']);
    }

    private function cartCount(array $cart): int
    {
        return array_sum(array_column($cart, 'quantity'));
    }
}
