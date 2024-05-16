<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterRenameCreatedByToCreatedById extends Migration
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
      $table->renameColumn('created_by', 'created_by_id');
      $table->unsignedBigInteger('updated_by_id')->default(1);
      $table->foreign('updated_by_id')
        ->on('admins')->references('id');
    });
    Schema::table('projects', function (Blueprint $table) {
      //
      $table->dropForeign('projects_created_by_foreign');
      $table->dropForeign('projects_updated_by_foreign');
      $table->renameColumn('created_by', 'created_by_id');
      $table->renameColumn('updated_by', 'updated_by_id');
      $table->foreign('created_by_id')
        ->on('admins')->references('id');
      $table->foreign('updated_by_id')
        ->on('admins')->references('id');
    });
    Schema::table('projects_vs_responsibles', function (Blueprint $table) {
      //
      $table->dropForeign('project_users_created_by_foreign');
      $table->dropForeign('project_users_updated_by_foreign');
      $table->renameColumn('created_by', 'created_by_id');
      $table->renameColumn('updated_by', 'updated_by_id');
      $table->foreign('created_by_id')
        ->on('admins')->references('id');
      $table->foreign('updated_by_id')
        ->on('admins')->references('id');
    });
    Schema::table('project_types', function (Blueprint $table) {
      //
      $table->dropForeign('project_types_created_by_foreign');
      $table->dropForeign('project_types_updated_by_foreign');
      $table->renameColumn('created_by', 'created_by_id');
      $table->renameColumn('updated_by', 'updated_by_id');
      $table->foreign('created_by_id')
        ->on('admins')->references('id');
      $table->foreign('updated_by_id')
        ->on('admins')->references('id');
    });
    Schema::table('tasks', function (Blueprint $table) {
      //
      $table->dropForeign('tasks_created_by_foreign');
      $table->dropForeign('tasks_updated_by_foreign');
      $table->renameColumn('created_by', 'created_by_id');
      $table->renameColumn('updated_by', 'updated_by_id');
      $table->foreign('created_by_id')
        ->on('admins')->references('id');
      $table->foreign('updated_by_id')
        ->on('admins')->references('id');
    });
    Schema::table('users', function (Blueprint $table) {
      //
      $table->dropForeign('clients_created_by_foreign');
      $table->dropForeign('clients_updated_by_foreign');
      $table->renameColumn('created_by', 'created_by_id');
      $table->renameColumn('updated_by', 'updated_by_id');
      $table->foreign('created_by_id')
        ->on('admins')->references('id');
      $table->foreign('updated_by_id')
        ->on('admins')->references('id');
    });
    Schema::table('notifications', function (Blueprint $table) {
      //
      $table->dropForeign('notifications_created_by_foreign');
      $table->renameColumn('created_by', 'created_by_id');
      $table->foreign('created_by_id')
        ->on('admins')->references('id');
      $table->unsignedBigInteger('updated_by_id')->default(1);
      $table->foreign('updated_by_id')
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
    Schema::table('responsibles', function (Blueprint $table) {
      //
    });
  }
}
