<?php

namespace App\Jobs;

use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Election\Models\Election;
use App\Modules\Election\Models\Municipality;
use App\Modules\Party\Models\Party;
use App\Modules\User\Models\TempCitizen;
use App\Modules\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SyncCitizens implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $election;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Election $election)
    {
        //
        $this->election = $election;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->election->update([
            'locked' => 1
        ]);
        DB::beginTransaction();
        $tempCitizens = TempCitizen::where('election_id', '=', $this->election->id)->get();
        foreach ($tempCitizens as $tempCitizen) {
            $comparedCitizen = User::where('civil_registration', $tempCitizen->civil_registration)
                ->where('fname', $tempCitizen->fname)
                ->where('lname', $tempCitizen->lname)
                ->where('mname', $tempCitizen->mname)
                ->where('mother_name', $tempCitizen->mother_name)->first();
            if (!$comparedCitizen) {
                $user = new User($tempCitizen->toArray());
                $municipality = Municipality::where('name', $tempCitizen->municipality)->first();
                if ($municipality) {
                    $user->municipality_id = $municipality->id;
                } else {
                    $user->municipality_id = Municipality::create(['name' => $tempCitizen->municipality])->id;
                }
                $party = Party::where('name', $tempCitizen->party)->first();
                $user->party_id = $party ? $party->id : null;
                $user->imported_by_id = Auth::id();
                $user->save();
                DB::table('elections_vs_users')->insert(['user_id' => $user->id, 'election_id' => $this->election->id, 'imported_by_id' => Auth::id(), 'color' => $tempCitizen->color]);
                $tempCitizen->delete();
            } else {
                DB::table('elections_vs_users')
                    ->insert(
                        [
                            'user_id' => $comparedCitizen->id,
                            'election_id' => $this->election->id,
                            'imported_by_id' => Auth::id(),
                            'color' => $tempCitizen->color
                        ]
                    );
                $tempCitizen->delete();
            }
        }
        DB::commit();
        $this->election->update([
            'locked' => 0
        ]);
    }
}
