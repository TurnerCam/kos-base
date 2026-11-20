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
        Schema::table('authentications', function (Blueprint $table) {
            //
            $table->datetime('lock_out')->nullable()->after('meta_data');
            $table->datetime('lock_in')->nullable()->after('meta_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authentications', function (Blueprint $table) {
            //
            $table->dropColumn('lock_in');
            $table->dropColumn('lock_out');
        });
    }
};
