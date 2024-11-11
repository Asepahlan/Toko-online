<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50'
        ]);

        try {
            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'icon' => $request->icon
            ]);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menambahkan kategori')
                ->withInput();
        }
    }

    public function edit(Category $category)
    {
        if (request()->ajax()) {
            return response()->json([
                'category' => $category
            ]);
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'icon' => 'nullable|string|max:50'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        try {
            $category->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil diperbarui',
                    'category' => $category
                ]);
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui kategori'
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat memperbarui kategori');
        }
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang memiliki produk');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
