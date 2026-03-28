<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankPerusahaan extends Model
{
    protected $table = 'bank_perusahaan';
    protected $fillable = ['nama_bank', 'cabang', 'nomor_rekening', 'atas_nama', 'is_active'];
}
