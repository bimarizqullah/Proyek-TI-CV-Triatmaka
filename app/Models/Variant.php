<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class Variant extends Model
{
    use HasFactory;
    protected $table = 'variant'; // Nama tabel di database

    protected $primaryKey = 'id'; // Primary key tabel

    public $timestamps = false; // Jika menggunakan created_at dan updated_at

    protected $fillable = [
        'users_id',
        'variant',
        'ukuran',
        'harga'
    ];

    public static function addVariant(Request $request) {
        $data = [
            'users_id' => Auth::id(),
            'variant' => $request->variant,
            'ukuran' => $request->ukuran,
            'harga' => $request->harga
        ];
        return self::create($data);
    }

    public static function updateVariant(Request $request, $id) {
        $variant = Variant::findOrFail($id);

        $variant->users_id = $request->Auth::id();
        $variant->variant = $request->variant;
        $variant->ukuran = $request->ukuran;
        $variant->harga = $request->harga;

        return $variant->save();
    }

    public static function validateData(Request $request){
        $rules = [
            'variant' => 'required|string',
            'ukuran' => 'required|in:500,750,1',
            'harga' => 'required|integer'
        ];

        return $request->validate($rules);
    }

    public function catalog() {
        return $this->hasMany(Catalog::class,'variant_id');
    }
}
