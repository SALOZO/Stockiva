<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPengiriman extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pengiriman';

    protected $fillable = [
        'pengiriman_id',
        'jenis',
        'file_path',
        'status',
        'catatan',
        'uploaded_by',
        'uploaded_at'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime'
    ];

    public function pengiriman(){
        return $this->belongsTo(Pengiriman::class);
    }

    public function uploader(){
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getStatusBadgeAttribute(){
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'verified' => '<span class="badge bg-success">Verified</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
