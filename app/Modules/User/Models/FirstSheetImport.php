<?php

namespace App\Modules\User\Models;

use App\Modules\Election\Models\Election;
use App\Modules\Election\Models\Municipality;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class FirstSheetImport implements ToCollection
{

    protected $election;

    public function __construct(Election $election)
    {
        //
        $this->election = $election;
    }

    public function collection(Collection $rows)
    {
        $arr = [];
        $municipality = Municipality::where('name', $rows[1][9])->first();
        if (!$municipality) {
            $municipality = Municipality::create(['name' => $rows[1][9]]);
        }
        $latestUser = User::select('id')->orderBy('id', 'DESC')->first();
        foreach ($rows as $key => $row) {
            if ($key > 0 && $row[0]) {
                $users = User::where('fname', $row[0])->where('lname', $row[1])->where('mname', $row[2])->where('mother_name', $row[3])->where('birth_date', $row[4])->where('municipality_id', $municipality->id)->get();
                if (!$users || count($users) == 0) {
                    $arr[] = [
                        'fname' => $row[0],
                        'lname' => $row[1],
                        'mname' => $row[2],
                        'mother_name' => $row[3],
                        'birth_date' => $row[4],
                        'gender' => ($row[5] === 'الإناث' || $row[5] === 'الذكور') ? ($row[5] === 'الإناث' ? 'الإناث' : 'الذكور') : ($row[6] === 'الإناث' ? 'الإناث' : 'الذكور'),
                        'personal_religion' => ($row[5] === 'الإناث' || $row[5] === 'الذكور') ? $row[6] : $row[5],
                        'civil_registration' => strpos($row[7], '/') > -1 ? str_replace('مكرر', '', explode("/", $row[7])[0]) : str_replace('مكرر', '', $row[7]),
                        'record_religion' => $row[8],
                        'municipality_id' => $municipality->id, // $rows[9] municipality
                        'district' => $row[10],
                        'governorate' => $row[11],
                        'constituency' => $row[12],
                        'outdoor' => $row[13] ? 1 : 0,
                        'color' => $row[14] ? 'white' : ($row[16] ? 'black' : 'grey'),
                        'imported_by_id' => Auth::id()
                    ];
                } elseif (count($users) > 1) {
                    abort(500, "some inputs are dublicated " . count($users) . " TIMES | fname: " . $row[0] . ' mname: ' . $row[1] . ' lname: ' . $row[2] . ' id=' . $key + 1);
                } else {
                    $ids[] = [
                        'user_id' => $users[0]->id,
                        'election_id' => $this->election->id,
                        'imported_by_id' => Auth::id(),
                        'color' => $row[14] ? 'white' : ($row[16] ? 'black' : 'grey'),
                        'outdoor' => $row[13] ? 1 : 0,
                    ];
                    DB::table('elections_vs_users')->where('election_id', $this->election->id)->where('user_id', $users[0]->id)->delete();
                }
            }
        }
        if (count($arr) > 1000) {
            $halved = array_chunk($arr, ceil(count($arr) / 2));
            foreach ($halved as $half) {
                User::insert($half);
            }
        } else {
            User::insert($arr);
        }
        if ($latestUser) {
            $newUsers = User::where('id', '>', $latestUser->id)->get();
        } else {
            $newUsers = User::all();
        }
        foreach ($newUsers as $user) {
            $ids[] = [
                'user_id' => $user->id,
                'election_id' => $this->election->id,
                'imported_by_id' => Auth::id(),
                'color' => $user->color,
                'outdoor' => $user->outdoor,
            ];
        }
        DB::table('elections_vs_users')->insert($ids);
    }
}
