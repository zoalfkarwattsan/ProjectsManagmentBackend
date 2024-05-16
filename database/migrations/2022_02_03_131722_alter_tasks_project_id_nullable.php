<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTasksProjectIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->dropForeign(['project_id']);
            $table->dropForeign(['status_id']);
        });
        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->foreign('project_id')
                ->on('projects')->references('id')
                ->onDelete('cascade');

            $table->foreign('status_id')
                ->on('statuses')->references('id')
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
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
}
