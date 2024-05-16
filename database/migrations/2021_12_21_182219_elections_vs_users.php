<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ElectionsVsUsers extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropForeign('users_box_id_foreign');
      $table->dropColumn('box_id');
      $table->dropForeign('users_responsible_id_foreign');
      $table->dropColumn('responsible_id');
    });
    Schema::create('elections_vs_users', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('election_id');
      $table->foreign('election_id')
        ->on('elections')->references('id');
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')
        ->on('users')->references('id');
      $table->unsignedBigInteger('responsible_id');
      $table->foreign('responsible_id')
        ->on('responsibles')->references('id');
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
    Schema::dropIfExists('elections_vs_users');
  }
}
