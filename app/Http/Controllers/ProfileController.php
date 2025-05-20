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
        $users = User::all();
        return view('backend.profile.index', compact('users'));
    }
    public function edit(User $user)
    
    {
        return view('backend.profile.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        User::validateDataProfile($request, $id);
        User::updateUserProfile($request, $id);
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

        $imagePath = $request->file('image_path')->store('profile', 'public');
        $user->image_path = $imagePath;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
