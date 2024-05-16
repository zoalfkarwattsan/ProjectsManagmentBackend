<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsiblesVsResponsibleTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('responsibles', function (Blueprint $table) {
            $table->dropForeign(['responsible_type_id']);
        });
        Schema::table('responsibles', function (Blueprint $table) {
            $table->dropColumn('responsible_type_id');
        });

        Schema::create('responsibles_vs_responsible_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('responsible_id');
            $table->unsignedBigInteger('responsible_type_id');

            $table->foreign('responsible_id')
                ->on('responsibles')->references('id')
                ->onDelete('cascade');
            $table->foreign('responsible_type_id')
                ->on('responsible_types')->references('id')
                ->onDelete('cascade');
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
        Schema::dropIfExists('responsibles_vs_responsible_types');
    }
}
