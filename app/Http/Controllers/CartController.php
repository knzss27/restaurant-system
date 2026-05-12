<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    // ... таны бусад методууд энд байна ...

    /**
     * Захиалга байршуулах
     */
    public function placeOrder(Request $request)
    {
        $cart = session('cart', []);

        $order = Order::create([
            'user_id'          => auth()->id(),
            'delivery_address' => $request->delivery_address,
            'phone'            => $request->phone,
            'payment_method'   => $request->payment_method,
            'notes'            => $request->notes,
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'subtotal'   => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Захиалга амжилттай үүслээ');
    }

    // =========================================================
    // QPay
    // =========================================================

    /**
     * QPay invoice үүсгэж QR буцаана
     */
    public function qpayCreate(Request $request)
    {
        // 1. QPay access token авах
        $tokenRes = Http::withBasicAuth(
            config('services.qpay.username'),
            config('services.qpay.password')
        )->post('https://merchant.qpay.mn/v2/auth/token');

        $token = $tokenRes->json('access_token');

        // 2. Invoice үүсгэх
        $invoiceRes = Http::withToken($token)
            ->post('https://merchant.qpay.mn/v2/invoice', [
                'invoice_code'             => config('services.qpay.invoice_code'),
                'sender_invoice_no'        => 'ORDER-' . time(),
                'invoice_receiver_code'    => 'terminal',
                'invoice_description'      => 'Crust & Grill захиалга',
                'amount'                   => $request->amount,
                'callback_url'             => route('checkout.qpay.callback'),
            ]);

        $data = $invoiceRes->json();

        if (! isset($data['invoice_id'])) {
            return response()->json(['error' => 'QPay invoice үүсгэхэд алдаа гарлаа'], 500);
        }

        // QR image нь qPay-с base64 PNG хэлбэрээр ирнэ
        return response()->json([
            'invoice_id' => $data['invoice_id'],
            'qr_image'   => $data['qr_image'],   // base64 PNG
        ]);
    }

    /**
     * Төлбөр хийгдсэн эсэхийг шалгана
     */
    public function qpayCheck(Request $request)
    {
        // Access token авах
        $tokenRes = Http::withBasicAuth(
            config('services.qpay.username'),
            config('services.qpay.password')
        )->post('https://merchant.qpay.mn/v2/auth/token');

        $token = $tokenRes->json('access_token');

        // Төлбөр шалгах
        $result = Http::withToken($token)
            ->post('https://merchant.qpay.mn/v2/payment/check', [
                'object_type'  => 'INVOICE',
                'object_id'    => $request->invoice_id,
                'offset'       => ['page_number' => 1, 'page_limit' => 1],
            ]);

        $data = $result->json();

        return response()->json([
            'paid' => isset($data['count']) && $data['count'] > 0,
        ]);
    }

    /**
     * QPay callback (webhook) — QPay сервер дуудна
     */
    public function qpayCallback(Request $request)
    {
        // Энд QPay-с ирсэн мэдээллийг боловсруулж
        // Order-ийн төлөв шинэчилж болно
        return response()->json(['status' => 'ok']);
    }
}