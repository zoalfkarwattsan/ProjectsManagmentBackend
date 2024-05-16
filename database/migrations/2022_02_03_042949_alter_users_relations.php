<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropForeign(['governate_id']);
            $table->dropForeign(['town_id']);
            $table->dropForeign(['constituency_id']);
            $table->dropForeign(['province_id']);
            $table->dropColumn(['governate_id', 'town_id', 'constituency_id', 'province_id']);
        });

        Schema::table('elections_vs_users', function (Blueprint $table) {
            //
            $table->dropForeign(['user_id']);
        });
        Schema::table('elections_vs_users', function (Blueprint $table) {
            //
            $table->foreign('user_id')
                ->on('users')->references('id')
                ->onDelete('cascade');
        });

        Schema::table('projects', function (Blueprint $table) {
            //
            $table->dropForeign('projects_client_id_foreign');
        });
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->foreign('user_id')
                ->on('users')->references('id')
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
        //
    }
}
