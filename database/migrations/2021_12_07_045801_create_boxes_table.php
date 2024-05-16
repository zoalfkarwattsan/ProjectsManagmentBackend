<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('boxes', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('province_id');
      $table->unsignedBigInteger('governate_id');
      $table->unsignedBigInteger('municipality_id');
      $table->unsignedBigInteger('delegate_id');
      $table->unsignedBigInteger('election_id');
      $table->integer('civil_registration_from');
      $table->integer('civil_registration_to');
      $table->string('gender');
      $table->timestamps();

      $table->foreign('province_id')
        ->on('provinces')->references('id');
      $table->foreign('governate_id')
        ->on('governates')->references('id');
      $table->foreign('municipality_id')
        ->on('municipalities')->references('id');
      $table->foreign('delegate_id')
        ->on('responsibles')->references('id');
      $table->foreign('election_id')
        ->on('elections')->references('id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('boxes');
  }
}
