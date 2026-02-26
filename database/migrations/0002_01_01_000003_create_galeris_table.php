<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeris', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ★ UUID Primary Key
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->enum('tipe', ['foto', 'video']);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes(); // ★ SoftDeletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
