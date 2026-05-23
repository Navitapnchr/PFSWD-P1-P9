<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function show(Category $category): Response
    {
        $category->load([

            'products' => fn($q) => $q
                ->where('status', 'active')
                ->with('seller')
                ->latest(),
        ]);

        return Inertia::render('Categories/Show', [

            'category' => $category,
        ]);
    }
}