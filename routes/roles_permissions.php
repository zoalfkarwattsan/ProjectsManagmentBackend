<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('roles', \App\Modules\Auth\RolePermission\Role\Controllers\RoleController::class);
    Route::get('permissions', [\App\Modules\Auth\RolePermission\Permission\Controllers\PermissionController::class, 'index']);
    Route::get('getAllRolesWithQ', [\App\Modules\Auth\RolePermission\Role\Controllers\RoleController::class, 'getAllRolesWithQ']);
});
