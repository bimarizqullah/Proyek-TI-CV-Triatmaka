<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Testimoni;
use App\Models\Catalog;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    // Menampilkan daftar testimoni
    public function index(Request $request)
    {
        $produks = Catalog::all();
        $testimoni = Testimoni::with('catalog')->get(); // Ambil testimoni beserta relasi produk
        $search = $request->input('search');

        // Menambahkan fitur pencarian
        $testimoni = Testimoni::when($search, function ($query) use ($search) {
            $query->where('nama_pelanggan', 'like', "%{$search}%");
        })->paginate(10); // Menggunakan pagination
        return view('backend.testimoni.index', compact('produks', 'testimoni'));
    }

    // Menambahkan testimoni baru
    public function store(Request $request)
    {
        $produks = Catalog::all(); // Ambil semua produk

        $request->validate([
            'nama_pelanggan' => 'required|string|min:8',
            'catalog_id' => 'required|exists:catalog,id', // Pastikan produk ada di tabel catalogs
            'deskripsi' => 'required|string|max:255',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'rating' => 'required|numeric|between:0,5',
        ]);

        if (Auth::check()) {
             // Simpan gambar ke storage dan dapatkan path-nya
        $imagePath = $request->file('image_path')->store('testimoni_images', 'public');

        // Simpan data testimoni
        Testimoni::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'catalog_id' => $request->catalog_id,
            'deskripsi' => $request->deskripsi,
            'image_path' => $imagePath,
            'rating' => $request->rating,
            'users_id' => Auth::user()->id,
        ]);
        }
       

        return redirect()->route('testimoni.index')->with('success', 'Testimoni added successfully');
    }

    // Menampilkan form untuk edit testimoni
    public function edit(Testimoni $testimoni)
    {
        $produks = Catalog::all(); // Ambil semua produk
        return view('backend.testimoni.edit', compact('testimoni', 'produks'));
    }

    // Memperbarui testimoni
    public function update(Request $request, Testimoni $testimoni)
    {
        $produks = Catalog::all();
        $request->validate([
            'nama_pelanggan' => 'required|string|min:8',
            'catalog_id' => 'required|exists:catalog,id',
            'deskripsi' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'rating' => 'required|numeric|between:0,5',
        ]);

        // Cek jika ada gambar baru
        if ($request->hasFile('image_path')) {
            // Simpan gambar baru dan dapatkan path-nya
            $imagePath = $request->file('image_path')->store('testimoni_images', 'public');
            $testimoni->image_path = $imagePath;
        }

        // Update data testimoni
        $testimoni->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'catalog_id' => $request->catalog_id,
            'deskripsi' => $request->deskripsi,
            'rating' => $request->rating,
        ]);

        return redirect()->route('testimoni.index')->with('success', 'Testimoni updated successfully');
    }

    // Menghapus testimoni
    public function destroy(Testimoni $testimoni)
    {
        $produks = Catalog::all();
        $testimoni->delete();
        return redirect()->route('testimoni.index')->with('success', 'Testimoni deleted successfully');
    }
}
