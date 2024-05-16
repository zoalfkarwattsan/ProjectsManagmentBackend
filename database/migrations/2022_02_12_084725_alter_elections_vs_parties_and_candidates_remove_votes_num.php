<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterElectionsVsPartiesAndCandidatesRemoveVotesNum extends Migration
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
            $table->dropColumn('votes_num');
        });
        Schema::table('candidates', function (Blueprint $table) {
            //
            $table->dropColumn('votes_num');
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
