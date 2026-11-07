<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function home()
    {
        $banners = Banner::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::orderBy('name')->get();
        $featured = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('banners', 'categories', 'featured'));
    }

    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $products = Product::with('category')
            ->where('is_active', true)
            ->when($request->category, fn ($q, $slug) => $q->whereHas('category', fn ($c) => $c->where('slug', $slug)))
            ->when($request->q, fn ($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load('category');
        $related = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }

    public function about()
{
    return view('about');
}
}