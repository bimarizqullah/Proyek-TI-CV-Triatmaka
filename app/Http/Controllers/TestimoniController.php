<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Menambahkan fitur pencarian
        $testimoni = Testimoni::when($search, function ($query) use ($search) {
            $query->where('nama_pelanggan', 'like', "%{$search}%");
        })->paginate(10); // Menggunakan pagination
        return view('backend.testimoni.index', compact('testimoni'));
    }

    public function create()
    {
        return view('backend.testimoni.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|min:8',
            'produk' => 'required|string|min:8',
            'deskripsi' => 'required|string|max:255',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'rating' => 'required|numeric|between:0,5',
        ]);
        
        // Simpan gambar ke storage dan dapatkan path-nya
        $imagePath = $request->file('image_path')->store('testimoni_images', 'public');

        Testimoni::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'produk' => $request->produk,
            'deskripsi' => $request->deskripsi,
            'image_path' => $imagePath,
            'rating' => $request->rating,
        ]);

        return redirect()->route('testimoni.index')->with('success', 'Testimoni added successfully');
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|min:8',
            'produk' => 'required|string|min:8',
            'deskripsi' => 'required|string|max:255',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'rating' => 'required|numeric|between:0,5',
        ]);

        // Cek apakah ada file baru yang diunggah
        if ($request->hasFile('image_path')) {
        
            if ($testimoni->image_path && Storage::disk('public')->exists($testimoni->image_path)) {
                Storage::disk('public')->delete($testimoni->image_path);
            }

            $imagePath = $request->file('image_path')->store('catalog_images', 'public');
            $testimoni->update([
                'nama_pelanggan' => $request->nama_pelanggan,
                'produk' => $request->produk,
                'deskripsi' => $request->deskripsi,
                'image_path' => $imagePath,
                'rating' => $request->rating,
            ]);

        } else {
            $testimoni->update([
                'nama_pelanggan' => $request->nama_pelanggan,
                'produk' => $request->produk,
                'deskripsi' => $request->deskripsi,
                'rating' => $request->rating,
            ]);
        }

        return redirect()->route('testimoni.index')->with('success', 'Testimoni updated successfully');
    }

    public function edit(Testimoni $testimoni)
    {
        return view('backend.testimoni.edit', compact('testimoni'));
    }
    
    public function destroy(Testimoni $testimoni)
    {
        $testimoni->delete();
        return redirect()->route('testimoni.index')->with('success', 'Testimoni deleted successfully');
    }

    
}