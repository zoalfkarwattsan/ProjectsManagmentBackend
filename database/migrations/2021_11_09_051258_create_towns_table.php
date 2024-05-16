<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTownsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('towns', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->timestamps();
    });
    \Illuminate\Support\Facades\DB::table('towns')->insert(['name' => 'Beirut']);
    \Illuminate\Support\Facades\DB::table('constituencies')->insert(['name' => 'Beirut']);
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('towns');
  }
}
