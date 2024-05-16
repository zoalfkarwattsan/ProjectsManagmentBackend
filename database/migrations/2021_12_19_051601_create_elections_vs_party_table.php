<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectionsVsPartyTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('elections_vs_party', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('election_id');
      $table->unsignedBigInteger('party_id');

      $table->foreign('election_id')
        ->on('elections')->references('id');
      $table->foreign('party_id')
        ->on('parties')->references('id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('elections_vs_party');
  }
}
