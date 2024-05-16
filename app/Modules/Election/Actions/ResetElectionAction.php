<?php


namespace App\Modules\Election\Actions;


use App\Modules\Election\Models\Election;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ResetElectionAction
{
    public static function execute(Election $election)
    {
        return;
        DB::table('elections_vs_users')->where('election_id', $election->id)->update(['voted' => 0, 'arrived' => 0]);
        DB::table('boxes')->whereIn('id', $election->boxes->pluck('id'))->update(['cancelled' => 0, 'white_paper' => 0, 'close_request' => 0, 'is_closed' => 0, 'last_sync_at' => Carbon::now()]);
        DB::table('responsibles')->update(['last_sync_at' => Carbon::now()]);
        DB::table('boxes_vs_parties')->whereIn('box_id', $election->boxes->pluck('id'))->update(['votes_num' => 0]);
        DB::table('boxes_vs_candidates')->whereIn('box_id', $election->boxes->pluck('id'))->update(['votes_num' => 0]);
    }

}
