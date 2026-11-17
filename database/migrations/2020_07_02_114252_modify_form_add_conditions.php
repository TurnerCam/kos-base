<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->renameColumn('submit_options', 'actions');
            $table->text('conditions')->after('submit_options')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->renameColumn('actions', 'submit_options');
            $table->dropColumn('conditions');
        });
    }
};
