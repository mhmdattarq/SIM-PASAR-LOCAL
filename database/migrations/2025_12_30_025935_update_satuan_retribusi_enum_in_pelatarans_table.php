<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum jadi support 'hari', 'bulan', 'tahun'
        DB::statement("ALTER TABLE pelatarans MODIFY COLUMN satuan_retribusi ENUM('hari', 'bulan', 'tahun') NOT NULL DEFAULT 'hari'");
    }

    public function down(): void
    {
        // Rollback kalau perlu (kembali ke hari & bulan aja)
        DB::statement("ALTER TABLE pelatarans MODIFY COLUMN satuan_retribusi ENUM('hari', 'bulan') NOT NULL DEFAULT 'hari'");
    }
};