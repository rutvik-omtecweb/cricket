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
        Schema::table('general_settings', function (Blueprint $table) {
            $table->boolean('health_card_document')->default(true)->after('email_encryption');
            $table->boolean('licence_document')->default(true)->after('health_card_document');
            $table->boolean('other_document')->default(true)->after('licence_document');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn('health_card_document');
            $table->dropColumn('licence_document');
            $table->dropColumn('other_document');
        });
    }
};
