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
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->foreignId('hipotesis_pakar_id')->nullable()->constrained('hipotesis')->onDelete('set null');
            $table->decimal('nilai_bayes_pakar', 5, 2)->nullable();
            $table->text('catatan_pakar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->dropColumn(['hipotesis_pakar_id', 'nilai_bayes_pakar']);
        });
    }
};
