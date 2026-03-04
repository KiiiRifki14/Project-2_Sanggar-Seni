<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kostums', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kostum');
            $table->enum('kategori', ['tari', 'musik', 'teater']);
            $table->text('deskripsi')->nullable();
            $table->string('nama_aksesoris')->nullable();
            $table->text('makna_warna')->nullable();
            $table->text('makna_ornamen')->nullable();
            $table->enum('kondisi_fisik', ['baik', 'cukup', 'rusak'])->default('baik');
            $table->string('foto_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kostums');
    }
};
