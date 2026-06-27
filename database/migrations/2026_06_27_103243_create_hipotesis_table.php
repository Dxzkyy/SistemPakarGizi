<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hipotesis', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // K01, K02, K03
            $table->string('nama'); // Gizi Kurang, Gizi Lebih, Gizi Seimbang
            $table->text('deskripsi')->nullable();
            $table->text('rekomendasi')->nullable(); // rekomendasi kebutuhan gizi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hipotesis');
    }
};
