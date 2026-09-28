<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surats';

    protected $fillable = [
        'mahasiswa_id',
        'jenis_surat_id',
        'nomor_pengajuan',
        'keperluan',
        'status',
        'catatan_admin',
        'file_surat',
        'tanggal_diproses',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_diproses' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function detailPengajuan()
    {
        return $this->hasOne(DetailPengajuan::class);
    }

    public function dokumenPengajuans()
    {
        return $this->hasMany(DokumenPengajuan::class);
    }

    public function riwayatPengajuans()
    {
        return $this->hasMany(RiwayatPengajuan::class);
    }
}