<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectorsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('electors', function (Blueprint $table) {
      $table->id();
      $table->integer('civil_registration_from');
      $table->integer('civil_registration_to');
      $table->string('religion');
      $table->enum('gender', ['male', 'female', 'mix']);
      $table->unsignedBigInteger('box_id');
      
      $table->foreign('box_id')
        ->on('boxes')->references('id');
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
    Schema::dropIfExists('electors');
  }
}
