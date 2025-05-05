<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'image_path', 'name', 'email', 'password','alamat', 'level', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function addUser($data){
        return self::create([
            'image_path' => $data['image_path'] ?? null,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'alamat' => $data['alamat'],
            'level' => $data['level'],
            'status' => $data['status']
        ]);
    }

    public static function updateUser($data, $id) {
        $user = User::findOrFail($id);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['name']);
        $user->alamat = $data['alamat'];
        $user->level = $data['level'];
        $user->status = $data['status'];

        if (isset($data['image_path']) && is_string($data['image_path'])) {
            if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
                Storage::disk('public')->delete($user->image_path);
            }
            $user->image_path = $data['image_path'];
        }

        return $user->save();
    }

    public function catalog(){
        return $this->hasMany(Catalog::class, 'users_id');
    }
}

