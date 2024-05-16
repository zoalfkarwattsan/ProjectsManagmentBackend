<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTablesColumnsToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_citizens', function (Blueprint $table) {
            //
            $table->string('fname')->nullable()->change();
            $table->string('mname')->nullable()->change();
            $table->string('lname')->nullable()->change();
            $table->string('mother_name')->nullable()->change();
            $table->string('birth_date')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('personal_religion')->nullable()->change();
            $table->string('civil_registration')->nullable()->change();
            $table->string('record_religion')->nullable()->change();
            $table->string('municipality')->nullable()->change();
        });
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('fname')->nullable()->change();
            $table->string('mname')->nullable()->change();
            $table->string('lname')->nullable()->change();
            $table->string('mother_name')->nullable()->change();
            $table->string('civil_registration')->nullable()->change();
            $table->string('personal_religion')->nullable()->change();
            $table->string('record_religion')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
