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
        'variant',
    ];

    public static function addCatalog(Request $request)
    {    
        $data = [
            'users_id'=>Auth::id(),
            'produk' => $request->produk,
            'deskripsi'=>$request->deskripsi,
            'variant'=>$request->variant
        ];
        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            $data['image_path'] = $request
                ->file('image_path')
                ->store('catalog_images', 'public');
        }
        return self::create($data);
    }

    public static function updateCatalog(Request $request, $id) {
        $catalog = Catalog::findOrFail($id);

        $catalog->produk = $request->produk;
        $catalog->deskripsi = $request->deskripsi;
        $catalog->variant = $request->variant;
        $catalog->users_id = Auth::id();

        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            if ($catalog->image_path && Storage::disk('public')->exists($catalog->image_path)) {
                Storage::disk('public')->delete($catalog->image_path);
            }
            $catalog->image_path = $request->file('image_path')->store('catalog_images', 'public');
        }
        return $catalog->save();
    }

    public static function validateData(Request $request, $isUpdate = false)
    {
        $rules = [
            'produk' => 'required|string|min:8',
            'deskripsi' => 'required|string|max:255',
            'variant' => 'required|in:Original,Pedas',
        ];

        if ($isUpdate) {
            $rules['image_path'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096';
        } else {
            $rules['image_path'] = 'required|image|mimes:jpeg,png,jpg,gif|max:4096';
        }

        return $request->validate($rules);
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('produk', 'like', "%{$search}%");
        }
        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function harga()
    {
        return $this->hasMany(Harga::class, 'catalog_id');
    }

    public function testimonis()
    {
        return $this->hasMany(Testimoni::class, 'produk');
    }
}
