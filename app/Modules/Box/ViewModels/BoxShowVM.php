<?php

namespace App\Modules\Box\ViewModels;

use App\Modules\Box\Models\Box;
use App\Modules\Candidate\Models\Candidate;
use Illuminate\Support\Facades\DB;

class BoxShowVM
{

    public static function handle($box)
    {

        $users = $box->users;
        $box->parties;
        $box->candidates;
        $box->setAttribute('total_voters', count($users));
        $box->setAttribute('total_voted_num', count($users->filter(function ($item) {
            return $item->pivot->voted;
        })));
        $box->setAttribute('remaining_total_voted_num', count($users->filter(function ($item) {
            return !$item->pivot->voted;
        })));
        $box->setAttribute('electors', $box->electors);
        $box->setAttribute('black', count($users->filter(function ($item) {
            return $item->pivot->voted && $item->pivot->color === 'black';
        })));
        $box->setAttribute('grey', count($users->filter(function ($item) {
            return $item->pivot->voted && $item->pivot->color === 'grey';
        })));
        $box->setAttribute('white', count($users->filter(function ($item) {
            return $item->pivot->voted && $item->pivot->color === 'white';
        })));
        unset($box->users);
        return $box;
    }

    public static function toArray(Box $box)
    {
        return ['box' => self::handle($box)];
    }

    public static function toAttr(Box $box)
    {
        return self::handle($box);
    }
}
