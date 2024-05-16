<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBoxesOndeleteConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boxes', function (Blueprint $table) {
            //
            $table->dropForeign(['municipality_id']);
            $table->dropForeign(['election_id']);
        });
        Schema::table('boxes', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('municipality_id')->nullable()->change();

            $table->foreign('municipality_id')
                ->on('municipalities')->references('id')
                ->onDelete('set null');

            $table->foreign('election_id')
                ->on('elections')->references('id')
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
        Schema::table('boxes', function (Blueprint $table) {
            //
        });
    }
}
