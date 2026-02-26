<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_les', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ★ UUID Primary Key
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('asal_sekolah');
            $table->string('nama_orang_tua');
            $table->string('no_hp_ortu', 20);
            $table->string('status')->default('menunggu'); // ★ String utk Enum cast
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
            $table->softDeletes(); // ★ SoftDeletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_les');
    }
};
