<?php


namespace App\Modules\User\Actions;


use App\Modules\User\Models\User;

class DeleteUserAction
{
    public static function execute(User $user)
    {
        if (count($user->projects) > 0) {
            abort(500, 'User has projects');
        }
        $user->delete();
    }

}
