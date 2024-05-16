<?php


namespace App\Modules\Auth\Responsible\Actions;

use App\Modules\Auth\Responsible\DTO\ResponsibleDTO;
use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Box\Models\Box;
use Illuminate\Support\Facades\DB;

class UpdateResponsibleAction
{
    public static function execute(Responsible $responsible, ResponsibleDTO $responsibleDTO, $responsible_types)
    {
        if (count($responsible->responsible_types) > 0 && $responsible->responsible_types->pluck('id')->toArray() != $responsible_types) {
            if ($responsible->responsible_types->where('id', 1)->first() && !in_array(1, $responsible_types)) {
                if (count($responsible->projects) > 0 || count($responsible->tasks) > 0) {
                    abort(500, 'Remove team member from all assigned projects & tasks');
                }
            }
            if ($responsible->responsible_types->where('id', 2)->first() && !in_array(2, $responsible_types)) {
                $boxes = Box::where('delegate_id', $responsible->id)->get();
                if (count($boxes) > 0) {
                    abort(500, 'Remove team member from all assigned boxes');
                }
            }
            if ($responsible->responsible_types->where('id', 3)->first() && !in_array(3, $responsible_types)) {
                $citizens = DB::table('elections_vs_users')->where('responsible_id', $responsible->id)->get();
                if (count($citizens) > 0) {
                    abort(500, 'Remove team member from all assigned citizens inside elections');
                }
            }
        }
        $responsible->update($responsibleDTO->toArray());
        $responsible->responsible_types()->sync($responsible_types);
        return $responsible;
    }

}
