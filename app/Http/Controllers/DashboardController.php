<?php

namespace App\Http\Controllers;


class DashboardController
{
    public function index(){
        return view('frontend.dashboard');
    }

    public function (){
        return view('frontend.beranda');
    }
}
