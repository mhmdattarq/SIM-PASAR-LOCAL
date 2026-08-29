<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedagangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nip')->nullable()->unique();
            $table->string('nama')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('nik', 16)->nullable()->unique();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->string('jenis_dagangan')->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_usaha')->nullable();
            $table->string('npwp')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_diri')->nullable();
            $table->string('foto_pedagang')->nullable();
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagangs');
    }
};