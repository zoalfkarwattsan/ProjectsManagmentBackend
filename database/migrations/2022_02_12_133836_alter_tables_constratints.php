<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablesConstratints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_types', function (Blueprint $table) {
            //
            $table->dropForeign(['created_by_id']);
            $table->dropForeign(['updated_by_id']);
        });
        Schema::table('project_types', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('created_by_id')->nullable()->change();
            $table->foreign('created_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');
            $table->unsignedBigInteger('updated_by_id')->nullable()->change();
            $table->foreign('updated_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');
        });


        Schema::table('projects', function (Blueprint $table) {
            //
            $table->dropForeign(['created_by_id']);
            $table->dropForeign(['updated_by_id']);
            $table->dropForeign(['project_type_id']);
            $table->dropForeign(['status_id']);
        });
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('created_by_id')->nullable()->change();
            $table->foreign('created_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');

            $table->unsignedBigInteger('updated_by_id')->nullable()->change();
            $table->foreign('updated_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');

            $table->unsignedBigInteger('project_type_id')->nullable()->change();
            $table->foreign('project_type_id')
                ->on('project_types')->references('id')
                ->onDelete('set null');

            $table->unsignedBigInteger('status_id')->nullable()->change();
            $table->foreign('status_id')
                ->on('statuses')->references('id')
                ->onDelete('set null');
        });


        Schema::table('projects_vs_responsibles', function (Blueprint $table) {
            //
            $table->dropForeign(['created_by_id']);
            $table->dropForeign(['updated_by_id']);
        });
        Schema::table('projects_vs_responsibles', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('created_by_id')->nullable()->change();
            $table->foreign('created_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');

            $table->unsignedBigInteger('updated_by_id')->nullable()->change();
            $table->foreign('updated_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');
        });


        Schema::table('responsibles', function (Blueprint $table) {
            //
            $table->dropForeign(['responsible_type_id']);
            $table->dropForeign(['updated_by_id']);
        });
        Schema::table('responsibles', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('responsible_type_id')->nullable()->change();
            $table->foreign('responsible_type_id')
                ->on('responsible_types')->references('id')
                ->onDelete('set null');

            $table->unsignedBigInteger('updated_by_id')->nullable()->change();
            $table->foreign('updated_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');
        });


        Schema::table('responsibles_vs_notifications', function (Blueprint $table) {
            //
            $table->dropForeign(['notification_id']);
        });
        Schema::table('responsibles_vs_notifications', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('notification_id')->change();
            $table->foreign('notification_id')
                ->on('notifications')->references('id')
                ->onDelete('cascade');
        });


        Schema::table('statuses', function (Blueprint $table) {
            //
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::table('statuses', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('created_by')->nullable()->change();
            $table->foreign('created_by')
                ->on('admins')->references('id')
                ->onDelete('set null');
            $table->unsignedBigInteger('updated_by')->nullable()->change();
            $table->foreign('updated_by')
                ->on('admins')->references('id')
                ->onDelete('set null');
        });


        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->dropForeign(['created_by_id']);
            $table->dropForeign(['updated_by_id']);
        });
        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('created_by_id')->nullable()->change();
            $table->foreign('created_by_id')
                ->on('admins')->references('id')
                ->onDelete('set null');
            $table->unsignedBigInteger('updated_by_id')->nullable()->change();
            $table->foreign('updated_by_id')
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
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
}
