<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BoxesVsUsers extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('boxes_vs_users', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('box_id');
      $table->foreign('box_id')
        ->on('boxes')->references('id');
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')
        ->on('users')->references('id');
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
    Schema::dropIfExists('boxes_vs_users');
  }
}
