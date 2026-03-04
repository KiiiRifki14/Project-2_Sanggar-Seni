<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_event');
            $table->enum('jenis_acara', ['pernikahan', 'festival', 'penyambutan', 'budaya', 'lainnya']);
            $table->string('klien');
            $table->text('lokasi');
            $table->date('tanggal_event');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->enum('status', ['persiapan', 'berlangsung', 'selesai', 'batal'])->default('persiapan');
            $table->enum('status_bayar', ['belum_dp', 'sudah_dp', 'lunas'])->default('belum_dp');
            $table->decimal('nominal_dp', 12, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
