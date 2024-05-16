<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('candidates', function (Blueprint $table) {
      $table->id();
      $table->string('fname');
      $table->string('mname');
      $table->string('lname');
      $table->string('mother_name');
      $table->string('birth_date');
      $table->string('gender');
      $table->string('personal_religion');
      $table->string('civil_registration');
      $table->string('record_religion');
      $table->string('party_id');
      $table->string('municipality_id');
      $table->unsignedBigInteger('election_id');
      $table->foreign('election_id')
        ->on('elections')->references('id');
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
    Schema::dropIfExists('candidates');
  }
}
