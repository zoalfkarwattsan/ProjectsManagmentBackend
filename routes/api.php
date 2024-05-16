<?php

use \Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('checkversion', function (Request $request) {
    if ($request->os == 'android') {
        return response()->json(['data' => ['version' => '1.1.5']], 200);
    } else {
        return response()->json(['data' => ['version' => '1.1.5']], 200);
    }
});

Route::group(['middleware' => ['auth:api', 'activeMember'], 'as' => 'api.'], function () {

    Route::get('responsible/projects', [\App\Modules\Project\Controllers\ProjectController::class, 'indexByAuthResponsible']);

    Route::post('task/change-status/{task}', [\App\Modules\Task\Controllers\TaskController::class, 'changeStatus'])->name('tasks.change-status');

    Route::get('tasks/byProject/{project}', [\App\Modules\Task\Controllers\TaskController::class, 'indexByProject'])->name('tasks.byProject');

    Route::post('notifications/store_token', [\App\Modules\Auth\Notification\Controllers\NotificationController::class, 'storeToken'])->name('notifications.storeToken');

    Route::get('box/active', [\App\Modules\Box\Controllers\BoxController::class, 'showActiveByAuth'])->name('box.active');

    Route::post('box/close', [\App\Modules\Box\Controllers\BoxController::class, 'closeBoxByAuth'])->name('box.close');

    Route::post('citizen/vote/{user}', [\App\Modules\Box\Controllers\BoxController::class, 'citizenVote'])->name('citizen.vote');

    Route::post('citizen/arrived/{user}', [\App\Modules\Box\Controllers\BoxController::class, 'citizenArrived'])->name('citizen.arrived');

    Route::post('vote/real', [\App\Modules\Box\Controllers\BoxController::class, 'realVote'])->name('citizen.vote');

    Route::get('election/active/parties', [\App\Modules\Party\Controllers\PartyController::class, 'activeParties'])->name('election.active.parties');

    Route::get('announcements/list', [\App\Modules\Announcement\Controllers\AnnouncementController::class, 'index'])->name('announcements.index');

    Route::get('responsible/getAssignedUsers', [\App\Modules\Auth\Responsible\Controllers\ResponsibleDashboardController::class, 'getAssignedUserByActiveElection'])->name('responsible.getAssignedUserByActiveElection');

    Route::get('responsible/notifications', [\App\Modules\Auth\Notification\Controllers\NotificationController::class, 'getAllNotificationByAuth'])->name('notifications.getAllNotificationByResponsible');

    Route::post('offline/syncElection', [\App\Modules\Election\Controllers\ElectionController::class, 'syncOfflineElection'])->name('elections.syncOfflineElection');

});
