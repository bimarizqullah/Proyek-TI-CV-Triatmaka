<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KatalogController extends Controller
{
    public function index(Request $request, Catalog $catalog)
    {
        $search = $request->input('search');

        // Menambahkan fitur pencarian
        $catalog = Catalog::when($search, function ($query) use ($search) {
            $query->where('produk', 'like', "%{$search}%");
        })->paginate(10); // Menggunakan pagination
        return view('backend.katalog.index', compact('catalog'));
    }

    public function create()
    {
        return view('backend.katalog.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'produk' => 'required|string|min:8',
        'deskripsi' => 'required|string|max:255',
        'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    
    // Simpan gambar ke storage dan dapatkan path-nya
    $imagePath = $request->file('image_path')->store('catalog_images', 'public');

    // Simpan data ke database
    Catalog::create([
        'produk' => $request->produk,
        'deskripsi' => $request->deskripsi,
        'image_path' => $imagePath, // Menggunakan path yang benar
    ]);

    return redirect()->route('backend.katalog.index')->with('success', 'Catalog added successfully');
}

public function update(Request $request, Catalog $katalog)
{
    $request->validate([
        'produk' => 'required|string|min:8',
        'deskripsi' => 'required|string|max:255',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Cek apakah ada file baru yang diunggah
    if ($request->hasFile('image_path')) {
        // Hapus gambar lama jika ada
        if ($katalog->image_path && Storage::disk('public')->exists($katalog->image_path)) {
            Storage::disk('public')->delete($katalog->image_path);
        }

        // Simpan gambar baru
        $imagePath = $request->file('image_path')->store('catalog_images', 'public');

        // Update data dengan gambar baru
        $katalog->update([
            'produk' => $request->produk,
            'deskripsi' => $request->deskripsi,
            'image_path' => $imagePath,
        ]);
    } else {
        // Update tanpa mengubah gambar
        $katalog->update([
            'produk' => $request->produk,
            'deskripsi' => $request->deskripsi,
        ]);
    }

    return redirect()->route('katalog.index')->with('success', 'Catalog updated successfully');
}


public function edit(Catalog $katalog)
{
    return view('backend.katalog.edit', compact('katalog'));
}



    public function destroy(Catalog $catalog)
    {
        $catalog->delete();
        return redirect()->route('katalog.index')->with('success', 'User deleted successfully');
    }
}