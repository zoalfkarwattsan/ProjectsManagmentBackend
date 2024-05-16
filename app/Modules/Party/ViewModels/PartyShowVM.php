<?php

namespace App\Modules\Party\ViewModels;

use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\Models\Election;
use App\Modules\Party\Models\Party;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PartyShowVM
{

    public static function handle($party)
    {

        $election = Election::where('active', 1)->first();
        if ($election) {
            $box = $election->boxes->where('delegate_id', Auth::guard('api')->id())->first();
            $partyCandidates = Candidate::where('party_id', $party->id)->where('election_id', $election->id)->get();
            $partyCandidates = $partyCandidates->map(function ($candidate) use ($box) {
                $candidate_rel = $candidate->boxes()->wherePivot('box_id', $box->id)->first();
                $votes_num = 0;
                if ($candidate_rel) {
                    $votes_num = $candidate_rel->pivot->votes_num;
                }
                $candidate->setAttribute('votes_num', $votes_num);
                return $candidate;
            });
            unset($party->candidates);
            $party->setAttribute('candidates', $partyCandidates);
            $votes = $party->boxes()->wherePivot('box_id', $box->id)->first();
            $party->setAttribute('votes_num', $votes ? $votes->pivot->votes_num : 0);
            unset($party->votes);
        }
        return $party;
    }

    public static function toArray(Party $party)
    {
        return ['party' => self::handle($party)];
    }

    public static function toAttr(Party $party)
    {
        return self::handle($party);
    }
}
