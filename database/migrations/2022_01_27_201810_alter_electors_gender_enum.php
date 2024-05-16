<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterElectorsGenderEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electors', function (Blueprint $table) {
            //
            $table->dropColumn('gender');
        });
        Schema::table('electors', function (Blueprint $table) {
            //
            $table->enum('gender', ['mix', 'الذكور', 'الإناث']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('electors', function (Blueprint $table) {
            //
        });
    }
}
