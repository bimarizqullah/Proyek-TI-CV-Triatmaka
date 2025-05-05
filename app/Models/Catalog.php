<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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

    public static function addCatalog(Request $request)
    {    
        $data = [
            'users_id'=>Auth::id(),
            'produk' => $request->produk,
            'deskripsi'=>$request->deskripsi,

        ];
        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            $data['image_path'] = $request
                ->file('image_path')
                ->store('catalog_images', 'public');
        }
        return self::create($data);
    }

    public static function updateCatalog($data, $id) {
        $catalog = Catalog::findOrFail($id);

        $catalog->image_path = $data['image_path'];
        $catalog->produk = $data['produk'];
        $catalog->deskripsi = $data['deskripsi'];
        $catalog->users_id = Auth::id();

        if (isset($data['image_path']) && is_string($data['image_path'])) {
            if ($catalog->image_path && Storage::disk('public')->exists($catalog->image_path)) {
                Storage::disk('public')->delete($catalog->image_path);
            }
            $catalog->image_path = $data['image_path'];
        }
        return $catalog->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function testimonis()
    {
        return $this->hasMany(Testimoni::class, 'produk');
    }
}
