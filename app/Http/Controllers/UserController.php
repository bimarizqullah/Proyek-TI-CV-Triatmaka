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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'alamat' => 'required|string',
            'password' => 'required|string|min:8',
            'level' => 'required|in:superadmin,admin',
            'status' => 'required|in:aktif,non-aktif',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $validated['password'] = bcrypt($request->password);
        if ($request->hasFile('image_path')) {
            $fotoPath = $request->file('image_path')->store('public/profile');
            $validated['image_path'] = basename($fotoPath);
        }
        User::addUser($validated);
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image_path' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'alamat' => 'required|string|max:255',
            'level' => 'required|in:superadmin,admin',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        $data = $request->all();

        if ($file = $request->file('image_path')) {
            $data['image_path'] = $file->store('profile', 'public');
        }
        User::updateUser($data, $id);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function changePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',  // Pastikan ada konfirmasi password
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Cek apakah password lama yang dimasukkan cocok dengan password yang tersimpan di database
        if (!Hash::check($request->current_password, $user->password)) {
            // Jika password lama tidak cocok, kembalikan dengan error
            return back()->with('error', 'Password lama salah');
        }

        // Update password langsung menggunakan query builder
        User::where('id', $user->id)
            ->update([
                'password' => Hash::make($request->new_password)
            ]);

        return back()->with('success', 'Password berhasil diganti');
    }
}
