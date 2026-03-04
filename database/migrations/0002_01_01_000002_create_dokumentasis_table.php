<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumentasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_acara', ['upacara_adat', 'festival', 'penyambutan_tamu', 'lainnya']);
            $table->year('tahun');
            $table->string('file_path');
            $table->enum('tipe', ['foto', 'video']);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasis');
    }
};
