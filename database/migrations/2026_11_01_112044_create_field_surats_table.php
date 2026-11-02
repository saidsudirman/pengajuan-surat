
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')
                ->constrained('jenis_surats')
                ->cascadeOnDelete();

            $table->string('label', 150);
            $table->string('nama_field', 100);
            $table->enum('tipe', [
                'text',
                'textarea',
                'date',
                'number',
                'email'
            ])->default('text');

            $table->boolean('wajib_diisi')->default(true);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->unique(['jenis_surat_id', 'nama_field']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_surats');
    }
};
