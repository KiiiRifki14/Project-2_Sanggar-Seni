<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('negosiasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->decimal('harga_penawaran', 12, 2);
            $table->enum('pihak', ['klien', 'sanggar']);
            $table->text('catatan')->nullable();
            $table->boolean('is_deal')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negosiasis');
    }
};
