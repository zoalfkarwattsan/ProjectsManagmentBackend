<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPartiesTableAddBgAndTextColor extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('parties', function (Blueprint $table) {
      //
      $table->string('background_color')->default('#ec7211');
      $table->string('text_color')->default('#ffffff');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('parties', function (Blueprint $table) {
      //
    });
  }
}
