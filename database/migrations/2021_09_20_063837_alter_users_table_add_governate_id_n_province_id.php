<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddGovernateIdNProvinceId extends Migration
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
      $table->unsignedBigInteger('governate_id');
      $table->foreign('governate_id')->on('governates')->references('id');
      $table->unsignedBigInteger('province_id');
      $table->foreign('province_id')->on('provinces')->references('id');
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
