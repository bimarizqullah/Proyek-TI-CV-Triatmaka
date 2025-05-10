<?php

namespace App\Models;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;



class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'image_path',
        'name',
        'email',
        'password',
        'alamat',
        'level',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function addUser(Request $request)
    {
        $data = [
            'image_path' => $request->image_path ?? null,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'level' => $request->level,
            'status' => $request->status,
        ];

        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            $data['image_path'] = $request
                ->file('image_path')
                ->store('profile', 'public');
        }

        return self::create($data);
    }

    public static function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->level = $request->level;
        $user->status = $request->status;

        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
                Storage::disk('public')->delete($user->image_path);
            }
            $user->image_path = $request->file('image_path')->store('profile', 'public');
        }

        return $user->save();
    }

    public static function validateData(Request $request, $isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->id)], // penting untuk update
            'alamat' => 'required|string',
            'level' => 'required|in:superadmin,admin',
            'status' => 'required|in:aktif,non-aktif',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ];

        if (!$isUpdate) {
            $rules['password'] = 'required|string|min:8';
        }

        return $request->validate($rules);
    }

    public static function updateUserProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
                Storage::disk('public')->delete($user->image_path);
            }
            $user->image_path = $request->file('image_path')->store('profile', 'public');
        }

        return $user->save();
    }

    public static function validateDataProfile(Request $request, $id = null) {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',    
                Rule::unique('users', 'email')->ignore($id),
            ],
            'alamat' => 'required|string|max:255',
            'image_path' =>'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ];

        return $request->validate($rules);
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        return $query;
    }


    public function catalog()
    {
        return $this->hasMany(Catalog::class, 'users_id');
    }
}
