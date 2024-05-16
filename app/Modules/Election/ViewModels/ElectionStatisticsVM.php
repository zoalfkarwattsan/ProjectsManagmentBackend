<?php

namespace App\Modules\Election\ViewModels;

use App\Modules\Box\Models\Box;
use App\Modules\Election\Models\Election;
use App\Modules\Party\Models\Party;

class ElectionStatisticsVM
{

    public static function handle(Election $election)
    {
        $statistices = collect();
        $initRow = [
            'box_id' => 'رقم القلم',
            'box_name' => 'اسم قلم الإقتراع',
            'voters_num' => 'عدد الناخبين',
            'voted_num' => 'عدد المقترعين',
            'cancelled' => 'عدد الأوراق الملغاة',
            'white_papers' => 'عدد الأوراق البيضاء'
        ];
        foreach ($election->parties as $party) {
            $initRow["party_$party->id"] = $party->name;
            foreach ($party->candidates as $candidate) {
                $initRow["candidate_$candidate->id"] = $candidate->fname . ' ' . $candidate->mname . ' ' . $candidate->lname;
            }
        }
        $statistices->add($initRow);
        $counter = 0;
        foreach ($election->boxes as $box) {
            $newRow = [
                'box_id' => ++$counter,
                'box_name' => $box->municipality->name . ' - ' . $box->name . ' - غرفة رقم ' . $box->room_number,
                'voters_num' => $box->users->count(),
                'voted_num' => $box->users->filter(function ($citizen) {
                    return $citizen->pivot->voted > 0;
                })->count(),
                'cancelled' => $box->cancelled,
                'white_papers' => $box->white_paper
            ];
            foreach ($election->parties as $party) {
                if ($box->parties->where('id', $party->id)->first()) {
                    $newRow["party_$party->id"] = $box->parties->where('id', $party->id)->first()->pivot->votes_num;
                } else {
                    $newRow["party_$party->id"] = '-';
                }
                foreach ($party->candidates as $candidate) {
                    if ($box->candidates->where('id', $candidate->id)->first()) {
                        $newRow["candidate_$candidate->id"] = $box->candidates->where('id', $candidate->id)->first()->pivot->votes_num;
                    } else {
                        $newRow["candidate_$candidate->id"] = '-';
                    }
                }
            }
            $statistices->add($newRow);
        }
        return $statistices;
    }

    public static function toArray(Election $election)
    {
        return ['election' => self::handle($election)];
    }

    public static function toAttr(Election $election)
    {
        return self::handle($election);
    }
}
