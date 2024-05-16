<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBoxesVsPartiesRels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boxes_vs_parties', function (Blueprint $table) {
            //
            $table->dropForeign(['party_id']);
        });
        Schema::table('boxes_vs_parties', function (Blueprint $table) {
            //
            $table->foreign('party_id')
                ->on('parties')->references('id')
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
        Schema::table('boxes_vs_parties', function (Blueprint $table) {
            //
        });
    }
}
