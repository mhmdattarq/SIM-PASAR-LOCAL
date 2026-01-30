<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->string('dokumen_path')->nullable()->after('keterangan');
            $table->string('dokumen_path_pemberitahuan')->nullable()->after('dokumen_path');
            $table->string('dokumen_path_pernyataan')->nullable()->after('dokumen_path_pemberitahuan');
        });
    }

    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn([
                'dokumen_path',
                'dokumen_path_pemberitahuan',
                'dokumen_path_pernyataan'
            ]);
        });
    }
};
