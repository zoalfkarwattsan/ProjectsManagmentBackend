<?php


namespace App\Modules\User\Actions;

use App\Modules\User\DTO\UserDTO;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateUserAction
{
    public static function execute(User $user, UserDTO $userDTO)
    {
        $user->update($userDTO->toArray());
        $user->updated_by_id = Auth::id();
        return $user;
    }

}
