<?php

namespace App\Http\Controllers;

use App\Models\Catalog;



class DashboardController extends Controller
{
    public function index(){
        return view('frontend.dashboard');
    }

    public function beranda(){
        $katalog = Catalog::all();
        return view('frontend.beranda', compact('katalog'));
    }
}
