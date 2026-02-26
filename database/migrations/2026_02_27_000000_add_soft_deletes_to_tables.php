<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom deleted_at untuk SoftDeletes
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('pendaftaran_les', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('reservasi_pentas', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('pendaftaran_les', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('reservasi_pentas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
