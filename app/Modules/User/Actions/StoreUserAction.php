<?php


namespace App\Modules\User\Actions;

use App\Modules\User\DTO\UserDTO;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;

class StoreUserAction
{

    public static function execute(UserDTO $userDTO)
    {
        $user = new User($userDTO->toArray());
        $user->created_by_id = Auth::id();
        $user->save();
        return $user;
    }
}
