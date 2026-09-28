<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_pengajuans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_surat_id')
                ->unique()
                ->constrained('pengajuan_surats')
                ->cascadeOnDelete();

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