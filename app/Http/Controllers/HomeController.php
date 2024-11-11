<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua kategori dengan menghitung jumlah produk
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        // Ambil produk terlaris berdasarkan total penjualan
        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->orderBy('total_sales', 'desc')
            ->take(4)
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }
}
