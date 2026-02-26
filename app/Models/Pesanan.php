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
        'created_by'
    ];

    protected $casts = [
        'tanggal_pesanan' => 'date',
        'total_keseluruhan' => 'decimal:2'
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
}
