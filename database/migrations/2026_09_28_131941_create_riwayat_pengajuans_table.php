<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_pengajuans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_surat_id')
                ->constrained('pengajuan_surats')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('status', [
                'menunggu',
                'diproses',
                'diterima',
                'ditolak',
                'selesai'
            ]);

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pengajuans');
    }
};