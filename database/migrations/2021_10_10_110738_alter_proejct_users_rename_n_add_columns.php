<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProejctUsersRenameNAddColumns extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('project_users', function (Blueprint $table) {
      //
      $table->unsignedBigInteger('responsible_id');
      $table->foreign('responsible_id')
        ->on('responsibles')->references('id');
      $table->unsignedBigInteger('project_id');
      $table->foreign('project_id')
        ->on('projects')->references('id');
    });
    Schema::rename('project_users', 'projects_vs_responsibles');
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('project_users', function (Blueprint $table) {
      //
    });
  }
}
