<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'image_path', 'name', 'email', 'password','alamat', 'level', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function catalog(){
        return $this->hasMany(Catalog::class, 'users_id');
    }
}

