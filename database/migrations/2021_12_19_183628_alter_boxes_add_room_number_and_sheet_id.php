<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBoxesAddRoomNumberAndSheetId extends Migration
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
      $table->integer('room_number');
      $table->integer('sheet_id');
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
