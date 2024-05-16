<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResponsiblesAddCreatedBy extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('responsibles', function (Blueprint $table) {
      //
      $table->dropColumn('type');

      $table->unsignedBigInteger('created_by')->default(1);
      $table->foreign('created_by')
        ->on('admins')->references('id');
      $table->unsignedBigInteger('responsible_type_id')->default(1);
      $table->foreign('responsible_type_id')
        ->on('responsible_types')->references('id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('responsibles', function (Blueprint $table) {
      //
      $table->dropForeign('responsibles_created_by_foreign');
      $table->dropColumn('created_by');
    });
  }
}
