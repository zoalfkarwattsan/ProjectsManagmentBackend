<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBoxesDeleteUnusedColumns extends Migration
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
      $table->dropForeign('boxes_province_id_foreign');
      $table->dropForeign('boxes_governate_id_foreign');
      $table->dropColumn(
        [
          'province_id',
          'governate_id',
          'gender',
          'civil_registration_from',
          'civil_registration_to',
        ]
      );
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
