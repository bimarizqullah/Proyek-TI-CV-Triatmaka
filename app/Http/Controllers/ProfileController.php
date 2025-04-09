<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request,User $user ) {
        return view('backend.profile.index', compact('users'));
    }
}
