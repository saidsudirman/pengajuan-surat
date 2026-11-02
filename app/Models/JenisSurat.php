<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surats';

    protected $fillable = [
        'nama_surat',
        'deskripsi',
        'template_surat',
        'isi_template',
        'status',
    ];

    public function pengajuanSurats()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function fieldSurats()
    {
        return $this->hasMany(FieldSurat::class)->orderBy('urutan');
    }
}
