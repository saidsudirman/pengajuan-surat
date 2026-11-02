<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pengaturan_surat', 'nama_yayasan')) {
            Schema::table('pengaturan_surat', function (Blueprint $table) {
                $table->string('nama_yayasan')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pengaturan_surat', 'nama_yayasan')) {
            Schema::table('pengaturan_surat', function (Blueprint $table) {
                $table->dropColumn('nama_yayasan');
            });
        }
    }
};