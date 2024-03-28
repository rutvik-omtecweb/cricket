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
        Schema::create('outer_news', function (Blueprint $table) {
            $table->uuid('id')->default(\Illuminate\Support\Str::uuid())->primary();
            $table->longText('link')->nullable();
            $table->integer('limit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outer_news');
    }
};
