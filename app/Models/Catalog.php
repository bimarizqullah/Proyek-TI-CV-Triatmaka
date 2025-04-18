<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $table = 'catalog'; // Nama tabel di database

    protected $primaryKey = 'id'; // Primary key tabel

    public $timestamps = true; // Jika menggunakan created_at dan updated_at

    protected $fillable = [
        'image_path',
        'produk',
        'deskripsi',
        'users_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function testimonis()
    {
        return $this->hasMany(Testimoni::class, 'produk');
    }
}
