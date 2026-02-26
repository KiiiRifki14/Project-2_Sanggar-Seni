<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi_pentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_acara', ['pernikahan', 'penyambutan', 'festival', 'lainnya']);
            $table->date('tanggal_pentas');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->decimal('durasi_jam', 4, 1);
            $table->text('lokasi_acara');
            $table->text('deskripsi_acara')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi_pentas');
    }
};
