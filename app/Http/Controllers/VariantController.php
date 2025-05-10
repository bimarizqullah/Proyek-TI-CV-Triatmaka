<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index()
    {
        $variants = Variant::all();
        return view('backend.variant.index', compact('variants'));
    }
    public function store(Request $request)
    {
        Variant::validateData($request);
        Variant::addVariant($request);
        return redirect()
        ->route('variant.index')
        ->with('success', 'Variant baru telah ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        Variant::validateData($request);
        Variant::updateVariant($request, $id);
        return redirect()
        ->route('variant.index')
        ->with('success', 'Variant telah diubah!');
    }
    public function destroy(Variant $variant)
    {
        $variant->delete();
        return redirect()
        ->route('variant.index')
        ->with('success', 'Variant telah diubah!');
    }
}
