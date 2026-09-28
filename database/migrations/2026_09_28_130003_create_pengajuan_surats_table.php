<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_surats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mahasiswa_id')
                ->constrained('mahasiswa')
                ->cascadeOnDelete();

            $table->foreignId('jenis_surat_id')
                ->constrained('jenis_surats')
                ->restrictOnDelete();

            $table->string('nomor_pengajuan')->unique();

            $table->text('keperluan');

            $table->enum('status', [
                'menunggu',
                'diproses',
                'diterima',
                'ditolak',
                'selesai'
            ])->default('menunggu');

            $table->text('catatan_admin')->nullable();

            $table->string('file_surat')->nullable();

            $table->timestamp('tanggal_diproses')->nullable();

            $table->timestamp('tanggal_selesai')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surats');
    }
};