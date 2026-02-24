<?php

namespace App\Models;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name_kategori',
    ];

    public function barang(){
        return $this->hasMany(Barang::class, 'kategori_id');
    }
    public function jenis(){
        return $this->hasMany(Jenis::class, 'kategori_id');
    }
}
