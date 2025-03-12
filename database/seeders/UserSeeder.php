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
            'name' => 'Bima Cahya',
            'email' => 'Bima@triatmakaofficial.com',
            'password' => Hash::make('password123'), // Gunakan bcrypt untuk enkripsi password
        ]);
    }
}
