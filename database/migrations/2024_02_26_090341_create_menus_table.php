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
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('id')->default(\Illuminate\Support\Str::uuid())->primary();
            $table->text('menu_name');
            $table->text('page_url')->nullable();
            $table->text('icon')->nullable();
            $table->foreignUuid('parent_id')->nullable();
            $table->integer('order');
            $table->boolean('is_active')->default(true);
            $table->foreignUuid('created_by')->nullable();
            $table->foreignUuid('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
