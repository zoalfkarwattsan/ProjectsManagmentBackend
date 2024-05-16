<?php


namespace App\Modules\Election\Actions;

use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\DTO\ElectionDTO;
use App\Modules\Election\Models\Election;
use App\Modules\Party\Models\Party;
use Carbon\Carbon;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreRealVoteAction
{

    public static function execute($request)
    {
        $election = Election::where('active', 1)->first();
        if (!$election) return null;
        $box = $election->boxes->where('delegate_id', Auth::guard('api')->id())->first();
        if (!$box) return null;
        if ($request->cancelled === 1) {
            $box->cancelled = $box->cancelled + 1;
            $box->update();
        } elseif ($request->white_paper === 1) {
            $box->white_paper = $box->white_paper + 1;
            $box->update();
        } else {
            if ($request->party_id) {
                $party = Party::find($request->party_id);
                $boxPartyRel = $party->boxes()->wherePivot('box_id', $box->id)->first();
                if ($boxPartyRel) {
                    $newVotesNum = $boxPartyRel->pivot->votes_num + 1;
                    $party->boxes()->updateExistingPivot($box->id, array('votes_num' => $newVotesNum));
                } else {
                    $newVotesNum = 1;
                    $party->boxes()->attach([$box->id => ['votes_num' => $newVotesNum]]);
                }

                if ($request->candidate_id) {
                    $candidate = Candidate::find($request->candidate_id);
                    $boxCandidateRel = $candidate->boxes()->wherePivot('box_id', $box->id)->first();
                    if ($boxCandidateRel) {
                        $candidate->boxes()->updateExistingPivot($box->id, array('votes_num' => $boxPartyRel->pivot->votes_num + 1));
                    } else {
                        $candidate->boxes()->attach([$box->id => ['votes_num' => 1]]);
                    }
                }
            }
        }
        return $election;
    }
}
