<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResponsiblesRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('projects_vs_responsibles', function (Blueprint $table) {
            //
            $table->dropForeign('project_users_responsible_id_foreign');
        });
        Schema::table('projects_vs_responsibles', function (Blueprint $table) {
            //
            $table->foreign('responsible_id')
                ->on('responsibles')->references('id')
                ->onDelete('cascade');
        });

        Schema::table('responsibles_vs_notifications', function (Blueprint $table) {
            //
            $table->dropForeign(['responsible_id']);
        });
        Schema::table('responsibles_vs_notifications', function (Blueprint $table) {
            //
            $table->foreign('responsible_id')
                ->on('responsibles')->references('id')
                ->onDelete('cascade');
        });

        // *********************************** //

        Schema::table('elections_vs_users', function (Blueprint $table) {
            //
            $table->dropForeign(['responsible_id']);
        });
        Schema::table('elections_vs_users', function (Blueprint $table) {
            //
            $table->foreign('responsible_id')
                ->on('responsibles')->references('id')
                ->onDelete('set null');
        });

        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->dropForeign(['responsible_id']);
        });
        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->foreign('responsible_id')
                ->on('responsibles')->references('id')
                ->onDelete('set null');
        });

        Schema::table('boxes', function (Blueprint $table) {
            //
            $table->dropForeign(['delegate_id']);
        });
        Schema::table('boxes', function (Blueprint $table) {
            //
            $table->foreign('delegate_id')
                ->on('responsibles')->references('id')
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
