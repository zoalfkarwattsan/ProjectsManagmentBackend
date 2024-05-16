<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddLocations extends Migration
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
            $table->string('district')->nullable();
            $table->string('governorate')->nullable();
            $table->string('constituency')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('district')->nullable();
            $table->string('governorate')->nullable();
            $table->string('constituency')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('municipality')->nullable();
            $table->string('color')->nullable();
            $table->unsignedBigInteger('municipality_id')->nullable()->change();
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
