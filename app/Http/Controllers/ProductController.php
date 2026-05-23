<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    // KATALOG
    public function index(Request $request): Response
    {
        $query = Product::where('status', 'active')
            ->with(['categories', 'seller'])
            ->withCount('reviews');
     
        $sort = $request->get('sort', 'latest');
        // FILTER KATEGORI
        if ($request->category) {

            $query->whereHas('categories', function ($q) use ($request) {

                $q->where('slug', $request->category);
            });
        }

        // SEARCH
        if ($request->search) {

            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }
        match($sort) {

            'price_asc' => $query->orderBy('price'),

            'price_desc' => $query->orderByDesc('price'),

            'popular' => $query->orderByDesc('views'),

            default => $query->latest(),
        };
        return Inertia::render('Products/Index', [

            'products' => $query->latest()
                ->paginate(12)
                ->withQueryString(),

            'categories' => Category::where('is_active', true)
                ->orderBy('sort_order')
                ->get(),

            'filters' => $request->only(
                'search',
                'category',
                'sort'
            ),
        ]);
    }

    // DETAIL PRODUK
    public function show(Product $product): Response
    {
        // tambah views
        $product->increment('views');

        // load relasi
        $product->load([
            'categories',
            'seller',

            'reviews' => fn($q) => $q
                ->with('user:id,name')
                ->latest(),
        ]);

        return Inertia::render('Products/Show', [

            'product' => $product,

            'produkLain' => Product::where(
                    'user_id',
                    $product->user_id
                )
                ->where('id', '!=', $product->id)
                ->where('status', 'active')
                ->take(4)
                ->get(),
        ]);
    }
}