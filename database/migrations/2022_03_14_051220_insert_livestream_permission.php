<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertLivestreamPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            ['name' => 'ELECTIONS_VIEW_LIVESTREAM', 'description' => 'View LiveStream', 'group' => 'Elections', 'guard_name' => 'web'],
        ]);
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
