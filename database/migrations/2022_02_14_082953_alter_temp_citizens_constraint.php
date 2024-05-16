<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTempCitizensConstraint extends Migration
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
            $table->dropForeign(['election_id']);
        });
        Schema::table('temp_citizens', function (Blueprint $table) {
            //
            $table->foreign('election_id')
                ->on('users')->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_citizens', function (Blueprint $table) {
            //
        });
    }
}
