<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengajuan extends Model
{
    use HasFactory;

    protected $table = 'detail_pengajuans';

    protected $fillable = [
        'pengajuan_surat_id',
        'ipk',
        'data_tambahan',
    ];

    public function pengajuanSurat()
    {
        return $this->belongsTo(PengajuanSurat::class);
    }
}