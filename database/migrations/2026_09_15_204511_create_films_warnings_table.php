<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('films_warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fk_id_film')->constrained('films');
            $table->foreignId('fk_id_warning')->constrained('warnings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films_warnings');
    }
};
