
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->enum('status_mahasiswa', [
                'aktif',
                'cuti',
                'nonaktif',
                'lulus',
            ])->default('aktif')->after('angkatan');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('status_mahasiswa');
        });
    }
};
