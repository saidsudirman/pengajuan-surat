<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPengajuan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pengajuans';

    protected $fillable = [
        'pengajuan_surat_id',
        'user_id',
        'status',
        'catatan',
    ];

    public function pengajuanSurat()
    {
        return $this->belongsTo(PengajuanSurat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}