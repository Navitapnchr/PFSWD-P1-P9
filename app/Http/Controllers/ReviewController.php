<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([

            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],

            'comment' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        // cek apakah user sudah review
        $sudahReview = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();

        if ($sudahReview) {

            return back()->withErrors([
                'review' => 'Anda sudah mereview produk ini.'
            ]);
        }

        Review::create([

            'user_id' => auth()->id(),

            'product_id' => $product->id,

            'rating' => $validated['rating'],

            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Review berhasil ditambahkan.');
    }
}