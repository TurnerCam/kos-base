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
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->ipAddress('submitter_ip')->after('submitted_by')->nullable();
            $table->string('submitter_agent')->after('submitter_ip')->nullable();
            $table->string('special_form')->nullable()->after('form_id')->nullable();
        });

        // Production made these required after they were filled in (SQLite cannot add them required).
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->ipAddress('submitter_ip')->nullable(false)->change();
            $table->string('submitter_agent')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropColumn('submitter_ip');
            $table->dropColumn('submitter_agent');
            $table->dropColumn('special_form');
        });
    }
};
