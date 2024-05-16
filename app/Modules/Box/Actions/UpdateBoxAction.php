<?php


namespace App\Modules\Box\Actions;

use App\Modules\Box\DTO\BoxDTO;
use App\Modules\Box\Models\Box;
use Carbon\Carbon;

class UpdateBoxAction
{
    public static function execute(Box $box, BoxDTO $boxDTO)
    {
        $box->update($boxDTO->toArray());
        if ($box->delegate_id > 0) {
            $oldBoxSameDelegate = Box::where('election_id', $box->election_id)->where('delegate_id', $box->delegate_id)->where('id', '!=', $box->id)->first();
            if ($oldBoxSameDelegate) {
                abort(500, 'Delegate already assigned to a box');
            }
        }
        $box->last_sync_at = Carbon::now();
        return $box;
    }

}
