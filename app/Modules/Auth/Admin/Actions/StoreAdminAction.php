<?php


namespace App\Modules\Auth\Admin\Actions;

use App\Modules\Auth\Admin\DTO\AdminDTO;
use App\Modules\Auth\Admin\Models\Admin;
use Illuminate\Support\Facades\Auth;

class StoreAdminAction
{

    public static function execute(AdminDTO $adminDTO)
    {
        $admin = new Admin($adminDTO->toArray());
        $admin->save();
        return $admin;
  }
}
