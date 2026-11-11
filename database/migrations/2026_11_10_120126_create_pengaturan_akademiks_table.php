
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_akademik', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik', 9);
            $table->enum('semester_aktif', ['Ganjil', 'Genap']);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_akademik');
    }
};
