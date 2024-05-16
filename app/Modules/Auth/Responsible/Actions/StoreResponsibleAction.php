<?php


namespace App\Modules\Auth\Responsible\Actions;

use App\Modules\Auth\Responsible\DTO\ResponsibleDTO;
use App\Modules\Auth\Responsible\Models\Responsible;

class StoreResponsibleAction
{

    public static function execute(ResponsibleDTO $responsibleDTO, $responsible_types)
    {
        $responsible = new Responsible($responsibleDTO->toArray());
        $responsible->created_by_id = auth()->id();
        $responsible->save();
        $responsible->responsible_types()->sync($responsible_types);
        return $responsible;
    }
}
