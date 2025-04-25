<?php

namespace App\Http\Controllers;

use App\Models\Catalog;

class DashboardController extends Controller
{
    public function index(){
        return view('frontend.dashboard');
    }
    public function berandaKatalog(){
        $katalog = Catalog::all();
        return view('frontend.beranda', compact('katalog'));
    }

    public function show($id)
    {
        $katalog = Catalog::findOrFail($id);
        return view('frontend.katalog.detail', compact('katalog'));
    }
    
}
