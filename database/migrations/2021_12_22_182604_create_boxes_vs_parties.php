<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxesVsParties extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('boxes_vs_parties', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('box_id');
      $table->foreign('box_id')
        ->on('boxes')->references('id');
      $table->unsignedBigInteger('party_id');
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
    Schema::dropIfExists('boxes_vs_parties');
  }
}
