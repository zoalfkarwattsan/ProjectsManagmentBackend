<?php


namespace App\Modules\Auth\Admin\Actions;

use App\Modules\Auth\Admin\DTO\AdminDTO;
use App\Modules\Auth\Admin\Models\Admin;
use Illuminate\Support\Facades\Auth;

class UpdateAdminAction
{
    public static function execute(Admin $admin, AdminDTO $adminDTO)
    {
        if ($admin->id === 1 && Auth::id() !== 1) {
            abort(500, 'Cannot Update this admin');
        }
        $admin->update($adminDTO->toArray());
        return $admin;
    }

}
