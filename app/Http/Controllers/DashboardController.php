<?php

namespace App\Http\Controllers;

use App\Models\Catalog;



class DashboardController extends Controller
{
    public function index(){
        return view('frontend.dashboard');
    }

<<<<<<< HEAD
    public function (){
        return view('frontend.beranda');
=======
    public function beranda(){
        $katalog = Catalog::all();
        return view('frontend.beranda', compact('katalog'));
>>>>>>> eabb820dd3ed1c3156fcc4d8ac98465d8a1e4cfc
    }
}
