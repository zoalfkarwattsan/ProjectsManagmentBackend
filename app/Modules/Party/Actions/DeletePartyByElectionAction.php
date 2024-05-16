<?php


namespace App\Modules\Party\Actions;


use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\Models\Election;
use App\Modules\Party\Models\Party;
use Illuminate\Support\Facades\DB;

class DeletePartyByElectionAction
{
  public static function execute(Party $party, Election $election)
  {
    DB::table('elections_vs_parties')->where('election_id', $election->id)->where('party_id', $party->id)->delete();
    Candidate::where('election_id', $election->id)->where('party_id', $party->id)->delete();
  }

}
