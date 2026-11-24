
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_pengajuans', function (Blueprint $table) {
            $table->enum('jenis_cuti', [
                'baru',
                'perpanjangan'
            ])->nullable()->after('data_tambahan');

            $table->unsignedTinyInteger('semester_cuti')
                ->nullable()
                ->after('jenis_cuti');

            $table->string('tahun_akademik_cuti')
                ->nullable()
                ->after('semester_cuti');
        });
    }

    public function down(): void
    {
        Schema::table('detail_pengajuans', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_cuti',
                'semester_cuti',
                'tahun_akademik_cuti'
            ]);
        });
    }
};
