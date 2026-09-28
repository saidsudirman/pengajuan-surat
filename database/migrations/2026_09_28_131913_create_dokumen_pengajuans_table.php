<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_pengajuans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_surat_id')
                ->constrained('pengajuan_surats')
                ->cascadeOnDelete();

            $table->string('nama_dokumen', 150);
            $table->string('file');
            $table->enum('status', [
                'menunggu',
                'valid',
                'tidak_valid'
            ])->default('menunggu');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_pengajuans');
    }
};