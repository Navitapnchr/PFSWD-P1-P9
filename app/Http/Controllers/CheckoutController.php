<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;
use Inertia\Response;

class CheckoutController extends Controller
{
    // HALAMAN CHECKOUT
    public function index(): Response
    {
        $cartItems = Cart::where('user_id', auth()->id())

            ->with('product')

            ->get();

        $total = $cartItems->sum(function ($item) {

            return $item->product->price * $item->qty;
        });

        return Inertia::render('Checkout/Index', [

            'cartItems' => $cartItems,

            'total' => $total,
        ]);
    }

    // PROSES CHECKOUT
    public function store(Request $request)
    {
        $validated = $request->validate([

            'shipping_address' => [
                'required',
                'string',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $cartItems = Cart::where('user_id', auth()->id())

            ->with('product')

            ->get();

        if ($cartItems->isEmpty()) {

            return back()->withErrors([
                'cart' => 'Keranjang kosong.'
            ]);
        }

        DB::transaction(function () use (
            $cartItems,
            $validated
        ) {

            $total = $cartItems->sum(function ($item) {

                return $item->product->price * $item->qty;
            });

            $order = Order::create([

                'user_id' => auth()->id(),

                'order_number' => 'ORD-' . now()->timestamp,

                'status' => 'pending',

                'total_amount' => $total,

                'shipping_address' => $validated['shipping_address'],

                'phone' => $validated['phone'],

                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cartItems as $item) {

                OrderItem::create([

                    'order_id' => $order->id,

                    'product_id' => $item->product->id,

                    'product_name' => $item->product->name,

                    'price' => $item->product->price,

                    'qty' => $item->qty,

                    'subtotal' => (
                        $item->product->price * $item->qty
                    ),
                ]);

                // kurangi stock
                $item->product->decrement(
                    'stock',
                    $item->qty
                );
            }

            // kosongkan cart
            Cart::where('user_id', auth()->id())
                ->delete();
        });

        return redirect('/dashboard')
            ->with(
                'success',
                'Checkout berhasil.'
            );
    }
}