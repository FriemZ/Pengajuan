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
        // Tabel Pengajuans
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pengaju utama (mahasiswa)
            $table->enum('jenis', ['magang', 'skripsi']);
            $table->enum('tipe', ['sendiri', 'kelompok']);
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('keperluan');
            $table->string('instansi')->nullable(); // Hanya untuk magang
            $table->string('alamat_instansi')->nullable(); // Menambahkan alamat_instansi
            $table->string('jangka_waktu')->nullable(); // Menambahkan jangka_waktu
            $table->string('file')->nullable(); // Hanya untuk file skripsi
            $table->timestamps();
        });


        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuans')->onDelete('cascade'); // Relasi dengan pengajuan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi dengan mahasiswa (user_id merujuk ke tabel users)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
