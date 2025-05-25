<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Harga;
use Illuminate\Http\Request;


class HargaController extends Controller
{

    public function index()
    {
        $catalogs = Catalog::all();
        return view('backend.harga.index', compact('catalogs'));
    }

    public function show($catalogId)
    {
        $catalog = Catalog::findOrFail($catalogId);
        $hargas = Harga::where('catalog_id', $catalogId)->get();

        return view('backend.harga.show', compact('catalog', 'hargas'));
    }

    public function store(Request $request)
    {
        Harga::validateData($request);
        Harga::addharga($request);

        return back()->with('success', 'Harga berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        Harga::validateData($request);
        Harga::updateHarga($request, $id);

        return back()->with('success', 'Harga berhasil diupdate');
    }
    public function destroy($id)
    {
        $harga = Harga::findOrFail($id);
        $harga->delete();

        return back()->with('success', 'Harga berhasil diupdate');
    }
}
