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
        Schema::create('gejala_hipotesis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gejala_id')->constrained('gejala')->onDelete('cascade');
            $table->foreignId('hipotesis_id')->constrained('hipotesis')->onDelete('cascade');
            $table->decimal('nilai_pakar', 3, 1); // 0.6, 0.7, 0.8
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gejala_hipotesis');
    }
};
