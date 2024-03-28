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
        Schema::create('live_scores', function (Blueprint $table) {
            $table->uuid('id')->default(\Illuminate\Support\Str::uuid())->primary();
            $table->longText('current_link')->nullable();
            $table->longText('past_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_scores');
    }
};
