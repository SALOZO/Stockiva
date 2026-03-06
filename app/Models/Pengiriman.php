<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';

    protected $fillable = [
        'pesanan_id',
        'no_pengiriman',
        'pengiriman_ke',
        'tanggal',
        'status',
        'penerima_ekspedisi',
        'penerima_client',
        'ekspedisi',
        'no_resi',
        'tanggal_kirim',
        'tanggal_terima',
        // 'catatan',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_kirim' => 'datetime',
        'tanggal_terima' => 'datetime',
    ];

    public function pesanan(){
        return $this->belongsTo(Pesanan::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusBadgeAttribute(){
        return match($this->status) {
            'pending' => '<span class="badge bg-secondary">Pending</span>',
            'diproses' => '<span class="badge bg-primary">Diproses</span>',
            'dikirim' => '<span class="badge bg-info">Dikirim</span>',
            'selesai' => '<span class="badge bg-success">Selesai</span>',
            'dibatalkan' => '<span class="badge bg-danger">Dibatalkan</span>',
            default => '<span class="badge bg-dark">Unknown</span>',
        };
    }
}
