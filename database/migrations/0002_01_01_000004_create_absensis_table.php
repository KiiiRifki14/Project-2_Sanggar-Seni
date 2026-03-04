<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('jadwal_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('personel_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['hadir', 'izin', 'absen'])->default('absen');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['jadwal_id', 'personel_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
