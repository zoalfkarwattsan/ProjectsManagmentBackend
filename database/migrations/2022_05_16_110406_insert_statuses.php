<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('statuses')->insert([
            [
                'name' => 'Pending',
                'created_at' => \Illuminate\Support\Carbon::now(),
                'icon_color' => 'warning'
            ], [
                'name' => 'Completed',
                'created_at' => \Illuminate\Support\Carbon::now(),
                'icon_color' => 'success'
            ], [
                'name' => 'On Going',
                'created_at' => \Illuminate\Support\Carbon::now(),
                'icon_color' => 'primary'
            ], [
                'name' => 'Rejected',
                'created_at' => \Illuminate\Support\Carbon::now(),
                'icon_color' => 'danger'
            ], [
                'name' => 'Failed',
                'created_at' => \Illuminate\Support\Carbon::now(),
                'icon_color' => 'danger'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boxes', function (Blueprint $table) {
            //
        });
    }
};
