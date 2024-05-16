<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBoxesProvinceAndGovernateNullable extends Migration
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
      $table->dropColumn('gender');
    });
    Schema::table('boxes', function (Blueprint $table) {
      //
      $table->unsignedBigInteger('province_id')->nullable()->change();
      $table->unsignedBigInteger('governate_id')->nullable()->change();
      $table->enum('gender', ['male', 'female', 'mix']);
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
