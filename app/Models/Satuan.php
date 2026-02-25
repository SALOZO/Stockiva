<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuans';
    protected $fillable = [
        'nama_satuan',
        'created_by'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function barang(){
        return $this->hasOne(Barang::class, 'satuan_id');
    }
}
