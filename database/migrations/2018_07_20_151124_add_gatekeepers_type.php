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
            $table->string('type')->after('description')->nullable();
        });

        // Production made this required after it was filled in (SQLite cannot add it required).
        Schema::table('gatekeepers', function (Blueprint $table) {
            $table->string('type')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gatekeepers', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
