<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('phone_num')->nullable();
            $table->bigInteger('national_number')->nullable();
            $table->string('civil_registration');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->on('users')->references('id');
            $table->softDeletes();
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
        Schema::dropIfExists('clients');
    }
}
