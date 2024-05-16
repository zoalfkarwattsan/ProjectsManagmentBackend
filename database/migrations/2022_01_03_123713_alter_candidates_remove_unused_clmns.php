<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCandidatesRemoveUnusedClmns extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('candidates', function (Blueprint $table) {
      //
      $table->dropColumn(['birth_date', 'personal_religion', 'record_religion', 'civil_registration', 'municipality_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('candidates', function (Blueprint $table) {
      //
    });
  }
}
