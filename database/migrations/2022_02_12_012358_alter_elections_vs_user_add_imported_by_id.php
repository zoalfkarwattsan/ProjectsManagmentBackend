<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterElectionsVsUserAddImportedById extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elections_vs_users', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('imported_by_id')->nullable();

            $table->foreign('imported_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('elections_vs_users', function (Blueprint $table) {
            //
        });
    }
}
