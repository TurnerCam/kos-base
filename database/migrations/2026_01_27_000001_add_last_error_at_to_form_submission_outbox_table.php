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
        Schema::table('form_submission_outbox', function (Blueprint $table) {
            // Track when the last error occurred
            $table->timestamp('last_error_at')->nullable()->after('last_error');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_submission_outbox', function (Blueprint $table) {
            $table->dropColumn('last_error_at');
        });
    }
};
