<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')->unique()->constrained()->onDelete('cascade');
            $table->decimal('harga_deal', 12, 2)->default(0);
            $table->decimal('estimasi_konsumsi', 12, 2)->default(0);
            $table->decimal('estimasi_transport', 12, 2)->default(0);
            $table->decimal('estimasi_sewa_kostum', 12, 2)->default(0);
            $table->decimal('estimasi_honor', 12, 2)->default(0);
            $table->decimal('real_konsumsi', 12, 2)->default(0);
            $table->decimal('real_transport', 12, 2)->default(0);
            $table->decimal('real_sewa_kostum', 12, 2)->default(0);
            $table->decimal('real_honor', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan_events');
    }
};
