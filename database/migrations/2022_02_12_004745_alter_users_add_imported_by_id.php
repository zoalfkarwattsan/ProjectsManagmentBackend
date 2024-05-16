<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddImportedById extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropForeign(['created_by_id']);
            $table->dropForeign(['updated_by_id']);
            $table->dropForeign(['municipality_id']);
            $table->dropForeign(['party_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('imported_by_id')->nullable();

            $table->foreign('imported_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');

            $table->foreign('created_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');

            $table->foreign('updated_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');

            $table->foreign('municipality_id')
                ->on('municipalities')->references('id')
                ->onDelete('set null');

            $table->foreign('party_id')
                ->on('parties')->references('id')
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
