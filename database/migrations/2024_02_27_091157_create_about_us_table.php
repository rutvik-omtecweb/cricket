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
        Schema::create('about_us', function (Blueprint $table) {
            $table->uuid('id')->default(\Illuminate\Support\Str::uuid())->primary();
            $table->longText('body')->nullable();
            $table->string('image')->nullable();
            $table->string('president')->nullable();
            $table->string('vice_president')->nullable();
            $table->string('treasurer')->nullable();
            $table->string('general_secretary')->nullable();
            $table->string('league_manager')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
