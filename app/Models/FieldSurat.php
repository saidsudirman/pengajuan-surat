<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldSurat extends Model
{
    use HasFactory;

    protected $table = 'field_surats';

    protected $fillable = [
        'jenis_surat_id',
        'label',
        'nama_field',
        'tipe',
        'wajib_diisi',
        'urutan',
    ];

    protected $casts = [
        'wajib_diisi' => 'boolean',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}
