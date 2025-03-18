<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Menambahkan fitur pencarian
        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->paginate(10); // Menggunakan pagination
    
        return view('backend.katalog.index', compact('katalogs'));
    }

    public function create()
    {
        return view('backend.katalog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'status' => 'required|in:aktif,non-aktif',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        return redirect()->route('backend.katalog.index')->with('success', 'Catalog added successfully');
    }

    public function edit(User $user)
    {
        return view('backend.katalog.edit', compact('katalog'));
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'status' => 'required|in:aktif,non-aktif',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'status' => $request->status,
    ]);

    return redirect()->route('backend.katalog.index')->with('success', 'Catalog updated successfully');
}



    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('katalog.index')->with('success', 'Catalog deleted successfully');
    }
}
