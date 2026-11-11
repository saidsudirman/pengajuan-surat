<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanAkademik extends Model
{
    protected $table = 'pengaturan_akademik';

    protected $fillable = [
        'tahun_akademik',
        'semester_aktif',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public static function aktif()
    {
        return static::where('status', true)->first();
    }
}
