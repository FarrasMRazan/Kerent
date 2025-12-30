<?php

namespace App\Http\Controllers;

use App\Models\Clothe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClotheController extends Controller
{
    public function index(Request $request)
    {
        $clothes = Clothe::with(['category', 'sizes'])->latest()->paginate(10);

        if ($request->ajax()) {
            return view('clothes._table', compact('clothes'))->render();
        }

        return view('clothes.index', compact('clothes'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();  
        return view('clothes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'character_name' => 'required|string|max:255',
            'series_name'    => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'price_per_day'  => 'required|numeric',
            'sizes'          => 'required|array',
            'image'          => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $path = $request->file('image')->store('clothes', 'public');

                $clothe = Clothe::create([
                    'user_id'        => Auth::id(),
                    'category_id'    => $request->category_id,
                    'character_name' => $request->character_name,
                    'series_name'    => $request->series_name,
                    // SOLUSI: Tambahkan fallback jika include_items tidak diisi
                    'include_items'  => $request->include_items ?? '-', 
                    'price_per_day'  => $request->price_per_day,
                    'image'          => $path,
                ]);

                foreach ($request->sizes as $sizeName => $stockAmount) {
                    $clothe->sizes()->create([
                        'size'  => strtoupper($sizeName),
                        'stock' => $stockAmount ?? 0
                    ]);
                }
            });

            return response()->json(['message' => 'Kostum dan stok berhasil disimpan!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['database' => [$e->getMessage()]]], 500);
        }
    }

    public function show(Clothe $clothe)
    {
    // Memuat relasi 'sizes' dan 'category'
    $clothe->load(['sizes', 'category']); 
    
    return view('clothes.show', compact('clothe'));
    }

    public function edit(Clothe $clothe)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $clothe->load('sizes');
        return view('clothes.edit', compact('clothe', 'categories'));
    }

    public function update(Request $request, Clothe $clothe)
    {
        $request->validate([
            'character_name' => 'required|string|max:255',
            'series_name'    => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'price_per_day'  => 'required|numeric',
            'sizes'          => 'required|array',
        ]);

        try {
            DB::transaction(function () use ($request, $clothe) {
                if ($request->hasFile('image')) {
                    if ($clothe->image) {
                        Storage::disk('public')->delete($clothe->image);
                    }
                    $clothe->image = $request->file('image')->store('clothes', 'public');
                }

                // SOLUSI EDIT: Pastikan include_items terupdate meskipun kosong
                $data = $request->except(['image', 'sizes']);
                $data['include_items'] = $request->include_items ?? '-';

                $clothe->update($data);

                foreach ($request->sizes as $sizeName => $stockAmount) {
                    $clothe->sizes()->updateOrCreate(
                        ['size' => strtoupper($sizeName)],
                        ['stock' => $stockAmount ?? 0]
                    );
                }
            });

            return response()->json(['message' => 'Data kostum berhasil diperbarui!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['database' => [$e->getMessage()]]], 500);
        }
    }

    public function destroy(Clothe $clothe)
    {
        try {
            if ($clothe->image) {
                Storage::disk('public')->delete($clothe->image);
            }
            $clothe->delete();
            
            if (request()->ajax()) {
                return response()->json(['message' => 'Kostum berhasil dihapus']);
            }

            return redirect()->route('clothes.index')->with('success', 'Kostum berhasil dihapus');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data'], 500);
        }
    }
}