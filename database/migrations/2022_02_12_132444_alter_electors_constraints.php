<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterElectorsConstraints extends Migration
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
            $table->dropForeign(['box_id']);
        });
        Schema::table('electors', function (Blueprint $table) {
            //
            $table->foreign('box_id')
                ->on('boxes')->references('id')
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
        Schema::table('electors', function (Blueprint $table) {
            //
        });
    }
}
