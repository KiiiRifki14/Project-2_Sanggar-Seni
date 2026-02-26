<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kelas');
            $table->enum('kategori', ['tari', 'musik', 'teater']);
            $table->text('deskripsi');
            $table->string('jadwal');
            $table->decimal('biaya', 12, 2);
            $table->integer('kuota')->default(20);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
