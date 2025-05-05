<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;



class KatalogController extends Controller
{
    public function index(Request $request, Catalog $catalog)
    {
        $catalogs = Catalog::all();
        $search = $request->input('search');
        $catalog = Catalog::when($search, function ($query) use ($search) {
            $query->where('produk', 'like', "%{$search}%");
        })->paginate(10);
        return view('backend.katalog.index', compact('catalog', 'catalogs'));
    }

    public function create()
    {
        $catalog = Catalog::all();
        return view('backend.katalog.create', compact('catalog'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk' => 'required|string|min:8',
            'deskripsi' => 'required|string|max:255',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        
        Catalog::addCatalog($request);

        return redirect()->route('katalog.index')->with('success', 'Catalog added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'produk' => 'required|string|min:8',
            'deskripsi' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $data = $request->all();

        if ($file = $request->file('image_path')) {
            $data['image_path'] = $file->store('catalog_images', 'public');
        }
        Catalog::updateCatalog($data, $id);
        return redirect()->route('katalog.index')->with('success', 'Catalog updated successfully');
    }

    public function edit(Catalog $katalog)
    {
        return view('backend.katalog.edit', compact('katalog'));
    }
    
    public function destroy(Catalog $katalog)
    {
        $katalog->delete();
        return redirect()->route('katalog.index')->with('success', 'Product deleted successfully');
    }
}