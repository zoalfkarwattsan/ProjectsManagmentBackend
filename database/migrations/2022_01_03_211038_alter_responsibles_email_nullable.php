<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResponsiblesEmailNullable extends Migration
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
      $table->string('email')->nullable()->change();
      $table->dropColumn('is_delegate');
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
    });
  }
}
