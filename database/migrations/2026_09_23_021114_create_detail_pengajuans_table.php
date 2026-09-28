<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pengajuans', function (Blueprint $table) {
            $table->id();

           $table->foreignId('pengajuan_surat_id')
            ->unique()
            ->constrained('pengajuan_surats')
            ->cascadeOnDelete();
            $table->string('nama_mahasiswa');
            $table->string('nim', 30);
            $table->string('program_studi', 150);
            $table->string('fakultas', 150)->nullable();
            $table->string('semester', 20)->nullable();
            $table->string('tahun_akademik', 20)->nullable();
            $table->decimal('ipk', 3, 2)->nullable();
            $table->text('data_tambahan')->nullable();
 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pengajuans');
    }
};