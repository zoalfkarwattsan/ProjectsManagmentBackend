<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterElectionsVsPartiesAddColor extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('elections_vs_party', function (Blueprint $table) {
      //
      $table->string('color');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('elections_vs_party', function (Blueprint $table) {
      //
    });
  }
}
