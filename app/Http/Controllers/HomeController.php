<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Hapus middleware auth agar halaman home bisa diakses publik
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // Clear cache terlebih dahulu
        Cache::forget('categories');

        $categories = Category::withCount('products')->get();

        // Debug untuk melihat data kategori
        Log::info('Categories:', $categories->toArray());

        $featuredProducts = Product::where('is_active', true)
                                 ->latest()
                                 ->take(8)
                                 ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }

    /**
     * Show products page.
     */
    public function products(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::withCount('products')->get();

        return view('products', compact('products', 'categories'));
    }
}
