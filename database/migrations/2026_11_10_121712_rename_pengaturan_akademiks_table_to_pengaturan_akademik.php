
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('pengaturan_akademiks', 'pengaturan_akademik');
    }

    public function down(): void
    {
        Schema::rename('pengaturan_akademik', 'pengaturan_akademiks');
    }
};
