<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'fakultas',
        'program_studi',
        'angkatan',
        'semester',
        'tahun_akademik',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuanSurats()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function getSemesterAktifAttribute()
    {
        $pengaturan = PengaturanAkademik::aktif();

        if (!$pengaturan || !$this->angkatan) {
            return null;
        }

        if (!preg_match('/^(\d{4})\/(\d{4})$/', $this->angkatan, $angkatan)) {
            return null;
        }

        if (!preg_match('/^(\d{4})\/(\d{4})$/', $pengaturan->tahun_akademik, $tahun)) {
            return null;
        }

        $tahunMasuk = (int) $angkatan[1];
        $tahunAktif = (int) $tahun[1];

        if ($tahunMasuk > $tahunAktif) {
            return null;
        }

        $semester = (($tahunAktif - $tahunMasuk) * 2) + 1;

        if ($pengaturan->semester_aktif === 'Genap') {
            $semester++;
        }

        return $semester;
    }
}
