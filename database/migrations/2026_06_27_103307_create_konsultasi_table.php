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
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipe', ['self', 'pakar']);
            $table->enum('status', ['pending', 'selesai'])->default('pending');
            $table->foreignId('hipotesis_id')->nullable()->constrained('hipotesis')->onDelete('set null');
            $table->decimal('nilai_bayes', 5, 2)->nullable(); // persentase
            $table->text('catatan_pakar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
