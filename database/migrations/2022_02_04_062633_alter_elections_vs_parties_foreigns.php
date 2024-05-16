<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterElectionsVsPartiesForeigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elections_vs_parties', function (Blueprint $table) {
            //
            $table->dropForeign('elections_vs_party_party_id_foreign');
            $table->dropForeign('elections_vs_party_election_id_foreign');
        });

        Schema::table('elections_vs_parties', function (Blueprint $table) {
            //
            $table->foreign('party_id')
                ->on('parties')->references('id')
                ->onDelete('cascade');
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
        Schema::table('elections_vs_parties', function (Blueprint $table) {
            //
        });
    }
}
