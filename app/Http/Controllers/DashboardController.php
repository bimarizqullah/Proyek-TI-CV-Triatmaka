<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Testimoni;

class DashboardController extends Controller
{
    public function index()
    {
        return view('frontend.dashboard');
    }
    public function beranda()
    {
        $katalog = Catalog::all();
        $testimoni = Testimoni::all();
        return view('frontend.beranda', compact('katalog', 'testimoni'));
    }

    public function show($id)
    {
        $katalog = Catalog::with('harga')->findOrFail($id);
        return view('frontend.katalog.detail', compact('katalog'));
    }

    
}
