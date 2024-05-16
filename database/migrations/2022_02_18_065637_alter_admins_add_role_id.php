<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAdminsAddRoleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
            $table->boolean('locked')->default(0);
            $table->string('description')->nullable();
        });
        Schema::table('permissions', function (Blueprint $table) {
            //
            $table->string('description')->nullable();
        });

        \Illuminate\Support\Facades\DB::table('roles')->insert(
            [
                ['name' => 'mobile', 'guard_name' => 'web', 'locked' => 1],
                ['name' => 'normal', 'guard_name' => 'web', 'locked' => 1],
            ]
        );
        \Spatie\Permission\Models\Role::find(1)->update(['locked' => 1]);

        Schema::table('admins', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('role_id')->nullable()->default(1);
            $table->foreign('role_id')
                ->on('roles')->references('id')
                ->onDelete('set null');
        });

        Schema::table('responsibles', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('role_id')->nullable()->default(2);
            $table->foreign('role_id')
                ->on('roles')->references('id')
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
        Schema::table('admins', function (Blueprint $table) {
            //
        });
    }
}
