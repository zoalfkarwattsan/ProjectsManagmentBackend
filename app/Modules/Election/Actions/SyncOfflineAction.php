<?php


namespace App\Modules\Election\Actions;


use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Box\Models\Box;
use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\Models\Election;
use App\Modules\Party\Models\Party;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SyncOfflineAction
{
    public static function execute($request)
    {
        $election = Election::where('active', 1)->first();
        $box = Box::find($request->id);
        $boxForceRefresh = isset($box->last_sync_at) && $box->last_sync_at ? \Carbon\Carbon::make($box->last_sync_at)->format('Y-m-d H:i:s') != $request['last_sync_at'] : true;
        if (!$election) return [
            'box' => [
                'force_refresh' => true
            ],
            'citizens' => [
                'force_refresh' => true
            ],
        ];
        if ($box && !$boxForceRefresh && $box->id == Box::where('delegate_id', Auth::guard('api')->id())->first()->id) {
            DB::table('elections_vs_users')
                ->whereIn('user_id', $request->voted_users)
                ->where('box_id', $box->id)
                ->update([
                    'voted' => 1,
                    'updated_at' => Carbon::now()
                ]);
            $box->close_request = $request['close_request'];
            $box->is_closed = $request['is_closed'];
            $box->cancelled = $request['real_votes']['cancelled'];
            $box->white_paper = $request['real_votes']['white_paper'];
            $box->received_data_at = Carbon::now();
            $box->last_sync_at = Carbon::now();
            $box->update();
            foreach ($request['real_votes']['parties'] as $party) {
                $tempParty = Party::find($party['id']);
                $boxPartyRel = $tempParty->boxes()->wherePivot('box_id', $box->id)->first();
                if ($boxPartyRel) {
                    $tempParty->boxes()->updateExistingPivot($box->id, array('votes_num' => $party['votes_num']));
                } else {
                    $tempParty->boxes()->attach([$box->id => ['votes_num' => $party['votes_num']]]);
                }
                foreach ($party['candidates'] as $candidate) {
                    if (isset($candidate['votes_num'])) {
                        $tempCandidate = Candidate::find($candidate['id']);
                        $boxCandidateRel = $tempCandidate->boxes()->wherePivot('box_id', $box->id)->first();
                        if ($boxCandidateRel) {
                            $tempCandidate->boxes()->updateExistingPivot($box->id, array('votes_num' => $candidate['votes_num']));
                        } else {
                            $tempCandidate->boxes()->attach([$box->id => ['votes_num' => $candidate['votes_num']]]);
                        }
                    }
                }
            }
        } else {
            if ($box && !$box->last_sync_at) {
                $box->last_sync_at = Carbon::now();
                $box->update();
            }
            $boxForceRefresh = true;
        }
        $responsible = Responsible::find(Auth::guard('api')->id());
        $citizensForceRefresh = isset($request['arrived_citizens']['last_sync_at']) ? $responsible->last_sync_at != $request['arrived_citizens']['last_sync_at'] : true;
        if (isset($request['arrived_citizens']) && !$citizensForceRefresh) {
            DB::table('elections_vs_users')
                ->whereIn('user_id', $request['arrived_citizens']['ids'])
                ->update([
                    'arrived' => 1,
                    'updated_at' => Carbon::now()
                ]);
        } else {
            if ($responsible && !$responsible->last_sync_at) {
                $responsible->last_sync_at = Carbon::now();
                $responsible->update();
            }
            $citizensForceRefresh = true;
        }
        return [
            'box' => [
                'last_sync_at' => isset($box->last_sync_at) ? \Carbon\Carbon::make($box->last_sync_at)->format('Y-m-d H:i:s') : '',
                // 'last_sync_at_local' => $request['last_sync_at'],
                'force_refresh' => $boxForceRefresh
            ],
            'citizens' => [
                'last_sync_at' => isset($responsible->last_sync_at) ? \Carbon\Carbon::make($responsible->last_sync_at)->format('Y-m-d H:i:s') : '',
                // 'last_sync_at_local' => $request['arrived_citizens']['last_sync_at'],
                'force_refresh' => $citizensForceRefresh
            ],
        ];
    }

}
