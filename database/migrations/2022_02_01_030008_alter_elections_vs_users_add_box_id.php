<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterElectionsVsUsersAddBoxId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elections_vs_users', function (Blueprint $table) {
            $table->dropForeign(['responsible_id']);
            $table->dropForeign(['election_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('elections_vs_users', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('box_id')->nullable();
            $table->enum('color', ['grey', 'black', 'white'])->default('grey');
            $table->boolean('voted')->default(0);

            $table->foreign('box_id')
                ->on('boxes')->references('id')
                ->onDelete('set null');

            $table->unsignedBigInteger('responsible_id')->nullable()->change();

            $table->foreign('responsible_id')
                ->on('responsibles')->references('id')
                ->onDelete('set null');

            $table->foreign('election_id')
                ->on('elections')->references('id')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->on('users')->references('id')
                ->onDelete('cascade');
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
