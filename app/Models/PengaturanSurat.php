<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_surat';

    protected $fillable = [
        'nama_universitas',
        'nama_yayasan',
        'nama_unit',
        'alamat',
        'telepon',
        'email',
        'website',
        'logo',
        'nama_pejabat',
        'jabatan_pejabat',
        'nip',
        'tanda_tangan',
        'stempel',
    ];
}
