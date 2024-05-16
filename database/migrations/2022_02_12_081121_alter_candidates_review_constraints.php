<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCandidatesReviewConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            //
            $table->dropForeign(['election_id']);
        });
        Schema::table('candidates', function (Blueprint $table) {
            //
            $table->string('mother_name')->nullable()->change();
            $table->unsignedBigInteger('party_id')->change();

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
        Schema::table('candidates', function (Blueprint $table) {
            //
        });
    }
}
