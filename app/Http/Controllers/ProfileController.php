<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth; // Tambahkan di atas
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Menambahkan fitur pencarian
        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->paginate(10); // Menggunakan pagination
    
        return view('backend.profile.index', compact('users'));
    }

    public function create()
    {
        return view('backend.profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'alamat'=>'required|string|max:255',
            'level' => 'required|in:superadmin,admin',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        $image_path = $request->file('image_path')->store('profile', 'public');
    
        User::create([
            'image_path' => $image_path,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat'=>$request->alamat,
            'level' => $request->level,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.profile.index')->with('success', 'User added successfully');
    }

    public function edit(User $user)
    {
        return view('backend.profile.edit', compact('user'));
    }

    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'alamat' => 'required|string|max:255',
    ]);

    if ($request->hasFile('image_path')) {
        $file = $request->file('image_path');
        $path = $file->store('profile', 'public');
    }

    $user->update($validated);

    return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
}



    public function updateFoto(Request $request, $id)
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user = User::findOrFail($id);
    
        // Hapus foto lama jika bukan default
        if ($user->image_path && $user->image_path != 'profile/default.png') {
            Storage::delete('public/' . $user->image_path);
        }
    
        // Simpan foto baru
        $imagePath = $request->file('image_path')->store('profile', 'public');
        $user->image_path = $imagePath;
        $user->save();
    
        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
    

}
