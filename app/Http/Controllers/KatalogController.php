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
        $catalog = Catalog::search($search)->paginate(10);
        return view('backend.katalog.index', compact('catalog', 'catalogs'));
    }

    public function create()
    {
        $catalog = Catalog::all();
        return view('backend.katalog.create', compact('catalog'));
    }

    public function store(Request $request)
    {
        Catalog::validateData($request);
        Catalog::addCatalog($request);
        return redirect()->route('katalog.index')->with('success', 'Catalog added successfully');
    }

    public function update(Request $request, $id)
    {
        Catalog::validateData($request, true);
        Catalog::updateCatalog($request, $id);
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
