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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->default(\Illuminate\Support\Str::uuid())->primary();
            $table->string('user_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('gender', ['Female', 'Male'])->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->longText('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('verification_id_1')->nullable();
            $table->string('verification_id_2')->nullable();
            $table->string('verification_id_3')->nullable();
            $table->longText('confirmation_message')->nullable();
            $table->boolean('is_approve')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_verify')->default(false);
            $table->boolean('terms_and_conditions')->default(false);
            $table->boolean('living_rmwb_for_3_month')->default(false);
            $table->boolean('not_member_of_cricket')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
