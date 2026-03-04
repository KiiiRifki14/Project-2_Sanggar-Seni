<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sewa_kostums', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('vendor_id')->constrained()->onDelete('cascade');
            $table->string('nama_kostum');
            $table->integer('jumlah')->default(1);
            $table->decimal('biaya_sewa', 12, 2);
            $table->date('tanggal_ambil')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['dipesan', 'diambil', 'dikembalikan', 'terlambat'])->default('dipesan');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sewa_kostums');
    }
};
