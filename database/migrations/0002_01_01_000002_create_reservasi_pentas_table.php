<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi_pentas', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ★ UUID Primary Key
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_acara', ['pernikahan', 'penyambutan', 'festival', 'lainnya']);
            $table->date('tanggal_pentas');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->decimal('durasi_jam', 4, 1);
            $table->text('lokasi_acara');
            $table->text('deskripsi_acara')->nullable();
            $table->string('status')->default('menunggu'); // ★ String utk Enum cast
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
            $table->softDeletes(); // ★ SoftDeletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi_pentas');
    }
};
