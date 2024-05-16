<?php


namespace App\Modules\Auth\Admin\Actions;


use App\Modules\Auth\Admin\Models\Admin;

class DeleteAdminAction
{
    public static function execute(Admin $admin)
    {
        if ($admin->id === 1) {
            abort(500, 'Cannot delete this admin');
        }
        $admin->delete();
    }

}
