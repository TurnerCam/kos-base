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
        // Two steps: since Laravel 11 a column added in the same step as a rename is created
        // before the rename, so "after" must name the column as it is after the rename.
        Schema::table('forms', function (Blueprint $table) {
            $table->renameColumn('submit_options', 'actions');
        });
        Schema::table('forms', function (Blueprint $table) {
            $table->text('conditions')->after('actions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->renameColumn('actions', 'submit_options');
            $table->dropColumn('conditions');
        });
    }
};
