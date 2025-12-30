<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        \App\Models\Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Mengubah "Genshin Impact" jadi "genshin-impact"
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function destroy(Category $category)
    {
        // Opsional: Berikan proteksi agar kategori yang masih dipakai di baju tidak bisa dihapus
        if ($category->clothes()->count() > 0) {
            return back()->with('error', 'Gagal! Kategori ini masih digunakan oleh beberapa kostum.');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
