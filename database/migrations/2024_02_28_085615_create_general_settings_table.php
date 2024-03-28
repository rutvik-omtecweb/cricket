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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->uuid('id')->default(\Illuminate\Support\Str::uuid())->primary();
            $table->text('site_name')->nullable();
            $table->text('phone')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('email')->nullable();
            $table->longText('address')->nullable();
            $table->text('copyright_text')->nullable();
            $table->boolean('maintenance')->default(1);
            $table->text('meta_title')->nullable();
            $table->text('meta_tag')->nullable();
            $table->text('meta_tag_keyword')->nullable();
            $table->string('facebook_key')->nullable();
            $table->string('twitter_key')->nullable();
            $table->string('instagram_key')->nullable();
            $table->string('company_email')->nullable();
            $table->string('mail_from_name')->nullable();
            $table->string('mail_protocol')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_user')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('email_encryption')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
