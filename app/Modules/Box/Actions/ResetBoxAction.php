<?php


namespace App\Modules\Box\Actions;


use App\Modules\Box\Models\Box;
use App\Modules\Election\Models\Election;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ResetBoxAction
{
    public static function execute(Box $box)
    {
        return;
        DB::table('elections_vs_users')
            ->where('box_id', $box->id)
            ->update(['voted' => 0, 'arrived' => 0]);
        DB::table('responsibles')
            ->whereIn(
                'id',
                DB::table('elections_vs_users')->where('box_id', $box->id)->pluck('responsible_id')
            )
            ->update(['last_sync_at' => Carbon::now()]);
        DB::table('boxes_vs_parties')->where('box_id', $box->id)->update(['votes_num' => 0]);
        DB::table('boxes_vs_candidates')->where('box_id', $box->id)->update(['votes_num' => 0]);
        $box->cancelled = 0;
        $box->white_paper = 0;
        $box->close_request = 0;
        $box->is_closed = 0;
        $box->last_sync_at = Carbon::now();
        $box->update();
    }

}
