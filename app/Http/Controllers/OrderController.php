<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_bank' => 'required|string',
            'shipping_courier' => 'required|string',
            'cart_items' => 'required|json',
        ]);

        $cartItems = json_decode($request->cart_items, true);

        if (empty($cartItems)) {
            return back()->withErrors(['cart' => 'Keranjang kosong!']);
        }
        
        $subtotal = collect($cartItems)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        $shippingRates = [
            'jtr' => 50000,
            'jnt' => 150000,
        ];
        
        $shippingCost = $shippingRates[$request->shipping_courier] ?? 0;
        $totalAmount = $subtotal + $shippingCost;

        // Generate unique Invoice ID like INV/20260407/123456
        $dateStr = date('Ymd');
        $random = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $orderId = "INV/{$dateStr}/{$random}";

        $order = Order::create([
            'id' => $orderId,
            'user_id' => Auth::id(),
            'address_id' => $request->address_id,
            'status' => 'belum-bayar',
            'total_amount' => $totalAmount,
            'shipping_cost' => $shippingCost,
            'payment_bank' => $request->payment_bank,
            'shipping_courier' => $request->shipping_courier,
        ]);

        foreach ($cartItems as $item) {
            // Find product and decrease stock
            $product = Product::find($item['id']);
            if ($product && $product->stock >= $item['quantity']) {
                $product->decrement('stock', $item['quantity']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_at_purchase' => $product->price,
                ]);
            }
        }

        return redirect()->route('payment.index', ['order' => $order->id]);
    }

    public function index()
    {
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->get();
        return view('orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'address'])->where('id', $id)->firstOrFail();
        
        // Ensure user can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order-details', compact('order'));
    }

    public function paymentProof($id)
    {
        $order = Order::where('id', $id)->firstOrFail();
        
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('payment-proof', compact('order'));
    }

    public function paid(Request $request)
    {
        $request->validate([
            'order_id'      => 'required|string',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $order = Order::where('id', $request->order_id)->firstOrFail();

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $path = $request->file('payment_proof')->store('proofs', 'public');
        $order->update([
            'status'        => 'menunggu-konfirmasi',
            'payment_proof' => $path,
        ]);

        return redirect()->route('orders.index')->with('success', 'Bukti pembayaran berhasil dikirim!');
    }
}
