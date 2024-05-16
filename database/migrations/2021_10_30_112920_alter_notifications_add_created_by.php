<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNotificationsAddCreatedBy extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('notifications', function (Blueprint $table) {
      //
      $table->unsignedBigInteger('created_by')->default(1);
      $table->foreign('created_by')
        ->on('admins')->references('id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('notifications', function (Blueprint $table) {
      //
    });
  }
}
