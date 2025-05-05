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
        User::validateData($request);
        User::addUser($request);
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        User::validateData($request, true);
        User::updateUser($request, $id);
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
