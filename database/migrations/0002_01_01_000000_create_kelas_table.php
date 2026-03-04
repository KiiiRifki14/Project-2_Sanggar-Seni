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
            $table->string('nama_tarian');
            $table->enum('kategori', ['tari', 'musik', 'teater']);
            $table->text('deskripsi');
            $table->text('filosofi_gerakan')->nullable();
            $table->text('sejarah_singkat')->nullable();
            $table->string('link_video_referensi')->nullable();
            $table->enum('tingkat_kesulitan', ['mudah', 'menengah', 'sulit'])->default('menengah');
            $table->string('foto_path')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
