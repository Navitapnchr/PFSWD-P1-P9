<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

            'products' => $query->paginate(12)
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
        $product->increment('views');

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

    // FORM CREATE
    public function create()
    {
        return Inertia::render('Seller/Products/Create', [
            'categories' => Category::where('is_active', true)->get(),
        ]);
    }

    // SIMPAN PRODUK
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required',
            'image' => 'nullable|image|max:2048',
            'category_ids' => 'nullable|array',
        ]);

        // upload gambar
        if ($request->hasFile('image')) {

            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        // tambah data tambahan
        $validated['slug'] = Str::slug($request->name) . '-' . time();

        $validated['user_id'] = auth()->id();

        // simpan produk
        $product = Product::create($validated);

        // simpan kategori
        if ($request->category_ids) {

            $product->categories()->sync(
                $request->category_ids
            );
        }

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // HAPUS PRODUK
    public function destroy(Product $product)
    {
        // hapus gambar
        if ($product->image) {

            Storage::disk('public')->delete(
                $product->image
            );
        }

        // hapus relasi kategori
        $product->categories()->detach();

        // hapus produk
        $product->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'Produk berhasil dihapus'
            );
    }
}