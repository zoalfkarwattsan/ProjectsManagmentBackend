<?php

namespace App\Modules\Box\ViewModels;

use App\Modules\Box\Models\Box;
use App\Modules\Election\Models\Election;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ActiveBoxShowVM
{
    public static function handle()
    {
        $election = Election::where('active', 1)->first();
        if (!$election) return null;
        $box = $election->boxes->where('delegate_id', Auth::guard('api')->id())->first();
        $box->last_requested_time = Carbon::now();
        $box->last_requested_by = Auth::guard('api')->id();
        $box->update();
        if (!$box) return null;
        $box->setAttribute('electors', $box->electors);
        $box->users;
        return $box;
    }

    public static function toArray()
    {
        return ['box' => self::handle()];
    }

    public static function toAttr()
    {
        return self::handle();
    }
}
