<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimonis'; // Nama tabel di database

    protected $primaryKey = 'id'; // Primary key tabel

    public $timestamps = true; // Jika menggunakan created_at dan updated_at

    protected $fillable = [
        'image_path',
        'nama_pelanggan',
        'produk',
        'deskripsi',
        'rating',
        'users_id'
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'produk');
    }
}
