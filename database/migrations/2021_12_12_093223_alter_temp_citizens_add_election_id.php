<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTempCitizensAddElectionId extends Migration
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
      $table->unsignedBigInteger('election_id');
      $table->foreign('election_id')
        ->on('elections')->references('id');
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
