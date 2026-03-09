<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanKirim extends Model
{
    use HasFactory;
    
    protected $table = 'satuan_kirim';
    
    protected $fillable = ['nama_satuan', 'singkatan'];
}
