<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $table = 'company_profiles';

    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'telepon',
        'email',
        'website',
        'logo',
        'nama_direktur',
        'jabatan_direktur',
    ];

    protected $hidden = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getAlamatLengkapAttribute()
    {
        $alamat = [];
        
        if ($this->alamat) $alamat[] = $this->alamat;
        if ($this->kelurahan) $alamat[] = $this->kelurahan;
        if ($this->kecamatan) $alamat[] = $this->kecamatan;
        if ($this->kota) $alamat[] = $this->kota;
        if ($this->provinsi) $alamat[] = $this->provinsi;
        if ($this->kode_pos) $alamat[] = $this->kode_pos;
        
        return implode(', ', $alamat);
    }

    public function getKontakLengkapAttribute()
    {
        $kontak = [];
        
        if ($this->telepon) $kontak[] = "Telp: {$this->telepon}";
        if ($this->email) $kontak[] = "Email: {$this->email}";
        if ($this->website) $kontak[] = "Web: {$this->website}";
        
        return implode(' | ', $kontak);
    }

    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        
        if (filter_var($this->logo, FILTER_VALIDATE_URL)) {
            return $this->logo;
        }
        
        if (file_exists(public_path($this->logo))) {
            return asset($this->logo);
        }
        
        return Storage::url($this->logo);
    }

    public function getLogoPathAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        
        $publicPath = public_path($this->logo);
        if (file_exists($publicPath)) {
            return $publicPath;
        }
        
        $storagePath = storage_path('public/' . $this->logo);
        if (file_exists($storagePath)) {
            return $storagePath;
        }
        
        return null;
    }

    public function scopeGetCompany($query)
    {
        return $query->first();
    }

    public static function updateProfile($data)
    {
        $company = self::first();
        
        if ($company) {
            $company->update($data);
        } else {
            $company = self::create($data);
        }
        
        return $company;
    }
}