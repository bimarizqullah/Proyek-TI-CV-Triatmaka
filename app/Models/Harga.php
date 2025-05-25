<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;
    protected $table = 'harga';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'users_id',
        'catalog_id',
        'ukuran',
        'harga'
    ];

    public static function addharga(Request $request){
        $data = [
            'users_id' => Auth::id(),
            'catalog_id' => $request->catalog_id,
            'ukuran' => $request->ukuran,
            'harga'=> $request->harga
        ];

        return self::create($data);
    }

    public static function updateHarga(Request $request, $id)
    {
        $harga = self::findOrFail($id);

        $harga->users_id = Auth::id();
        $harga->catalog_id = $request->catalog_id;
        $harga->ukuran = $request->ukuran;
        $harga->harga = $request->harga;
        return $harga->save();
    }


    public static function validateData(Request $request){
        $rules = [
            'ukuran'=> 'required|in:80,100,250,500,1000',
            'harga' => 'required|integer'
        ];

        return $request->validate($rules);
    }

    public function catalog(){
        return $this->belongsTo(Catalog::class , 'catalog_id');
    }

}
