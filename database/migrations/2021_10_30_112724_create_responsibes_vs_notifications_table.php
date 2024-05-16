<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsibesVsNotificationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('responsibles_vs_notifications', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('responsible_id');
      $table->foreign('responsible_id')
        ->on('responsibles')->references('id');
      $table->unsignedBigInteger('notification_id');
      $table->foreign('notification_id')
        ->on('notifications')->references('id');
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
    Schema::dropIfExists('responsibles_vs_notifications');
  }
}
