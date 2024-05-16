<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResponsiblesAndCandidatesImageRemoveNullabe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('responsibles', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('responsibles', function (Blueprint $table) {
            $table->string('image')->default('storage/avatar.png');
        });
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('image')->default('storage/avatar.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
