<?php


namespace App\Modules\Box\Actions;

use App\Modules\Box\DTO\BoxDTO;
use App\Modules\Box\Models\Box;
use App\Modules\Box\Models\Elector;
use Illuminate\Support\Facades\DB;

class UpdateBoxElectorsAction
{
    public static function execute(Box $box, $electors, $new)
    {
        DB::beginTransaction();
        $box->users()->update(array('box_id' => null));
        $box->electors()->delete();
        foreach ($electors as $key => $elector) {
            $newElector = Elector::create([
                'civil_registration_from' => $elector['civil_registration_from'],
                'civil_registration_to' => $elector['civil_registration_to'],
                'religion' => $elector['religion'],
                'gender' => $elector['gender'],
                'box_id' => $box->id
            ]);
            $users = $box->election->users
                ->where('municipality_id', '=', $box->municipality_id)
                ->where('record_religion', $newElector->religion)
                ->whereBetween('civil_registration', [$newElector->civil_registration_from, $newElector->civil_registration_to])
                ->filter(function ($item) use ($elector) {
                    if ($elector['gender'] != 'mix') {
                        return $item->gender === $elector['gender'];
                    }
                    return true;
                });
            if (count($users->filter(function ($item) {
                    return $item->pivot->box_id;
                })) > 0) {
                DB::rollBack();
                if ($new) {
                    $box->delete();
                }
                // $duplicatedCitizens = $users->filter(function ($item) {
                //     return $item->pivot->box_id;
                // });
                // abort('515', 'Some Citizens are already exists in another box :' . $duplicatedCitizens);
                abort('515', 'Some Citizens are already exists in another box');
            }
            $box->election->users()->newPivotStatement()->whereIn('user_id', $users->pluck('id'))->update(array('box_id' => $box->id));;
        }
        DB::commit();
    }

}
