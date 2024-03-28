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
        Schema::create('payment_collects', function (Blueprint $table) {
            $table->uuid('id')->default(\Illuminate\Support\Str::uuid())->primary();
            $table->foreignUuid('user_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('amount')->nullable();
            $table->string('transaction_id')->nullable();
            $table->date('expired_date')->nullable();
            $table->enum('status', ['success', 'pending', 'cancel'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_collects');
    }
};
