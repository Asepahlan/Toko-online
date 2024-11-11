<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('category')->where('is_active', true);

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori (single selection)
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter berdasarkan rentang harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Urutkan produk
        switch ($request->sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
                                 ->where('id', '!=', $product->id)
                                 ->where('is_active', true)
                                 ->inRandomOrder()
                                 ->take(4)
                                 ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
