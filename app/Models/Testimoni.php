<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimonis'; // Nama tabel di database

    protected $primaryKey = 'id'; // Primary key tabel

    public $timestamps = true; // Jika menggunakan created_at dan updated_at

    protected $fillable = [
        'image_path',
        'nama_pelanggan',
        'catalog_id',
        'deskripsi',
        'rating',
        'users_id'

    ];

    public static function addTestimoni(Request $request)
    {
        $data = [
            'image_path' => $request->image_path ?? null,
            'nama_pelanggan' => $request->nama_pelanggan,
            'catalog_id' => $request->catalog_id,
            'deskripsi' => $request->deskripsi,
            'rating' => $request->rating,
            'users_id' => Auth::id(),
        ];

        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            $data['image_path'] = $request
                ->file('image_path')
                ->store('testimoni_images', 'public');
        }
        return self::create($data);
    }

    public static function updateTestimoni(Request $request, $id)
    {
        $testimoni = self::findOrFail($id);

        $testimoni->nama_pelanggan = $request->nama_pelanggan;
        $testimoni->catalog_id = $request->catalog_id;
        $testimoni->deskripsi = $request->deskripsi;
        $testimoni->rating = $request->rating;
        $testimoni->users_id = Auth::id();

        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            if ($testimoni->image_path && Storage::disk('public')->exists($testimoni->image_path)) {
                Storage::disk('public')->delete($testimoni->image_path);
            }
            $testimoni->image_path = $request->file('image_path')->store('testimoni_images', 'public');
        }
        return $testimoni->save();
    }

    public static function validateData(Request $request, $isUpdate = false)
    {
        $rules = [
            'nama_pelanggan' => 'required|string',
            'catalog_id' => 'required|exists:catalog,id',
            'deskripsi' => 'required|string|max:255',
            'rating' => 'required|numeric|between:0,5',
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
            $query->where('nama_pelanggan', 'like', "%{$search}%");
        }
        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }
}
