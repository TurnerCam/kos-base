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
        Schema::table('team_assignments', function (Blueprint $table) {
            $table->integer('gatekeeper_id')->default(0)->after('team_id');
            $table->string('status', 50)->default('active')->after('team_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_assignments', function (Blueprint $table) {
            $table->dropColumn('gatekeeper_id');
            $table->dropColumn('status');
        });
    }
};
