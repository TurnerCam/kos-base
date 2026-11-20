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
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->after('id')->nullable();
            $table->string('first_name')->after('id')->nullable();
            $table->text('notes')->after('acl')->nullable();
            $table->string('postal')->after('acl')->nullable();
            $table->string('province')->after('acl')->nullable();
            $table->string('city')->after('acl')->nullable();
            $table->string('address')->after('acl')->nullable();
            $table->string('phone')->after('acl')->nullable();
            $table->date('date_withdrawn')->after('acl')->nullable();
            $table->date('date_hiatus_end')->after('acl')->nullable();
            $table->date('date_hiatus_start')->after('acl')->nullable();
            $table->date('date_admitted')->after('acl')->nullable();
            $table->date('date_applied')->after('acl')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        // Production made these required after they were filled in. Done as a change, not on the
        // add above, because SQLite cannot add a required column without a default.
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('province')->nullable(false)->change();
            $table->string('postal')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
