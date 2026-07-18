<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    // HALAMAN CART
    public function index(): Response
    {
        $cartItems = Cart::where('user_id', auth()->id())

            ->with('product')

            ->latest()

            ->get();

        $total = $cartItems->sum(function ($item) {

            return $item->product->price * $item->qty;
        });

        return Inertia::render('Cart/Index', [

            'cartItems' => $cartItems,

            'total' => $total,
        ]);
    }

    // TAMBAH KE CART
    public function store(Product $product)
    {
        $cart = Cart::firstOrCreate(

            [
                'user_id' => auth()->id(),

                'product_id' => $product->id,
            ],

            [
                'qty' => 1,
            ]
        );

        // kalau sudah ada
        if (!$cart->wasRecentlyCreated) {

            $cart->increment('qty');
        }

        return back()->with(
            'success',
            'Produk masuk cart.'
        );
    }

    // HAPUS CART
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {

            abort(403);
        }

        $cart->delete();

        return back();
    }
}