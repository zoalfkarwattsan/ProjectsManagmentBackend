<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddColumns extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      //
      $table->timestamp('birth_date')->nullable();
      $table->unsignedBigInteger('town_id')->nullable();
      $table->foreign('town_id')
        ->on('towns')->references('id');
      $table->unsignedBigInteger('constituency_id')->nullable();
      $table->foreign('constituency_id')
        ->on('constituencies')->references('id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      //
    });
  }
}
