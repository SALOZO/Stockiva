<?php

namespace App\Models;

use App\Models\DetailPesanan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
     use HasFactory;

    protected $table = 'pesanans';

    protected $fillable = [
        'no_pesanan',
        'client_id',
        'tanggal_pesanan',
        'status',
        'total_keseluruhan',
        'keterangan',
        'sph_status',
        'gudang_status',
        'sph_file',
        'sph_approved_file',
        'approved_at',
        'approved_by',
        'approval_notes',
        'created_by'
    ];

    protected $casts = [
        'tanggal_pesanan' => 'date',
        'total_keseluruhan' => 'decimal:2',
        'approved_at' => 'datetime',
        'gudang_status' => 'string',
    ];

    // Relasi ke Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relasi ke Detail Pesanan
    public function details(){
        return $this->hasMany(DetailPesanan::class);
    }

    // Relasi ke User (pembuat)
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke User (approver)
    public function approvedBy(){
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Generate nomor pesanan otomatis
    public static function generateNoPesanan(){
        $date = now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', now()->toDateString())->orderBy('id', 'desc')->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->no_pesanan, -4));
            $number = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $number = '0001';
        }

        return "PO-{$date}-{$number}";
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute(){
        return match($this->status) {
            'baru' => '<span class="badge bg-info">Baru</span>',
            'diproses' => '<span class="badge bg-warning">Diproses</span>',
            'selesai' => '<span class="badge bg-success">Selesai</span>',
            'dibatalkan' => '<span class="badge bg-danger">Dibatalkan</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
    public function getGudangStatusBadgeAttribute(){
    return match($this->gudang_status) {
        'Menunggu' => '<span class="badge bg-secondary">Menunggu</span>',
        'Sedang diproses' => '<span class="badge bg-primary">Diproses</span>',
        'Siap_dikirim' => '<span class="badge bg-info">Siap Dikirim</span>',
        'Dikirim' => '<span class="badge bg-warning">Dikirim</span>',
        'Diterima' => '<span class="badge bg-success">Diterima</span>',
        default => '<span class="badge bg-dark">Unknown</span>',
    };
}
}
