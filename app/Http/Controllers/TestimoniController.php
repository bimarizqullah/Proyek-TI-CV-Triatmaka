<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Testimoni;
use App\Models\Catalog;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index(Request $request)
    {
        $produks = Catalog::all();
        $search = $request->input('search');
        $testimoni = Testimoni::search($search)->paginate(10);
        return view('backend.testimoni.index', compact('produks', 'testimoni'));
    }
    public function store(Request $request)
    { 
        Testimoni::validateData($request);
        Testimoni::addTestimoni($request);
        return redirect()->route('testimoni.index')->with('success', 'Testimoni added successfully');
    }
    public function edit(Testimoni $testimoni)
    {
        $produks = Catalog::all(); 
        return view('backend.testimoni.edit', compact('testimoni', 'produks'));
    }
    public function update(Request $request, $id)
    {
        Testimoni::validateData($request, true);
        Testimoni::updateTestimoni($request, $id);
        return redirect()->route('testimoni.index')->with('success', 'Catalog updated successfully');
    }

    public function destroy(Testimoni $testimoni)
    {
        $testimoni->delete();
        return redirect()->route('testimoni.index')->with('success', 'Testimoni deleted successfully');
    }
}
