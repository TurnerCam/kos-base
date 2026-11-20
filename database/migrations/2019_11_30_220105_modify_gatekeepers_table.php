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
        Schema::table('gatekeepers', function (Blueprint $table) {
            $table->integer('team_id')->after('auth_key')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gatekeepers', function (Blueprint $table) {
            $table->dropColumn('team_id');
        });
    }
};
