<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Menambahkan fitur pencarian
        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->paginate(10); // Menggunakan pagination
    
        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'alamat' => 'required|string',
        'password' => 'required|string|min:6',
        'level' => 'required|in:superadmin,admin',
        'status' => 'required|in:aktif,non-aktif',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image_path')) {
        $imagePath = $request->file('image_path')->store('profile', 'public');
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'password' => hash::make($request->password),
        'level' => $request->level,
        'status' => $request->status,
        'image_path' => $imagePath,
    ]);

    return redirect()->route('backend.users.index')->with('success', 'User berhasil ditambahkan');
}


    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'image_path' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'alamat'=>'required|string|max:255',
        'level' => 'required|in:superadmin,admin',
        'status' => 'required|in:aktif,non-aktif',
    ]);

    if ($request->hasFile('image_path')) {
        
        if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
            Storage::disk('public')->delete($user->image_path);
        }

        $image_path = $request->file('image_path')->store('profile', 'public');
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'level' => $request->level,
            'status' => $request->status,
            'image_path' => $image_path,
        ]);

    } else {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'level' => $request->level,
            'status' => $request->status,
            'image_path' => $request->image_path,
        ]);
    }
    return redirect()->route('backend.users.index')->with('success', 'User updated successfully');
}


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
