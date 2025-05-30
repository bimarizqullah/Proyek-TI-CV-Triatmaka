<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'image_path'=> 'default.png',
            'name' => 'Bima Cahya',
            'email' => 'Bima@triatmakaofficial.com',
            'password' => Hash::make('password123'), // Gunakan bcrypt untuk enkripsi password
            'alamat'=> 'Madiun',
        ]);
    }
}
