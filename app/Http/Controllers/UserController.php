<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'alamat'=>'required|string|max:255',
            'level' => 'required|in:superadmin,admin',
            'status' => 'required|in:aktif,non-aktif',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat'=>$request->alamat,
            'level' => $request->level,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.users.index')->with('success', 'User added successfully');
    }

    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'alamat'=>'required|string|max:255',
        'level' => 'required|in:superadmin,admin',
        'status' => 'required|in:aktif,non-aktif',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'level' => $request->level,
        'status' => $request->status,
    ]);

    return redirect()->route('backend.users.index')->with('success', 'User updated successfully');
}



    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
