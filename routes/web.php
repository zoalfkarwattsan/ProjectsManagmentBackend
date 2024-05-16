<?php

use App\Helpers\Files;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('setting/all', function () {
    return response()->json(['message' => '', 'data' => ['app' => ['langs' => ['ar', 'en']]]], 200);
});

Route::post('support/store', function (Request $request) {
    return response()->json(['message' => 'Success'], 200);
});

Route::post('aa/dd/{id}', function ($id) {
    set_time_limit(0);
    $boxes = \App\Modules\Box\Models\Box::where('election_id', 8)->where('id', '>=', $id)->get();
    // $boxes = \App\Modules\Box\Models\Box::where('id',$id)->get();
    foreach ($boxes as $box) {
        try {
            var_dump('start :' . $box->id);
            \App\Modules\Box\Actions\UpdateBoxElectorsAction::execute($box, $box->electors, false);
            var_dump('end :' . $box->id);
        } catch (\Exception $e) {
            var_dump('error in :' . $box->id . ' ' . $box->name);
        }
    }
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('send/notification', [\App\Modules\Auth\Notification\Controllers\NotificationDashboardController::class, 'sendWebNotification'])->name('send.notification');

    Route::post('file/upload', function (\Illuminate\Http\Request $request) {
        return \App\Helpers\Helper::createSuccessResponse(['file' => Files::defaultUpload($request['file'])], 'File uploaded successfully');
    })->name('file.upload');

//  Admins
    Route::resource('admins', \App\Modules\Auth\Admin\Controllers\AdminDashboardController::class);
    Route::get('admin/getAllAdminsWithQ', [\App\Modules\Auth\Admin\Controllers\AdminDashboardController::class, 'getAllAdminsWithQ']);

//  Responsibles
    Route::resource('responsibles', \App\Modules\Auth\Responsible\Controllers\ResponsibleDashboardController::class);
    Route::delete('responsible/activateTeamMember/{responsible}', [\App\Modules\Auth\Responsible\Controllers\ResponsibleDashboardController::class, 'activateTeamMember']);
    Route::delete('responsible/deActivateTeamMember/{responsible}', [\App\Modules\Auth\Responsible\Controllers\ResponsibleDashboardController::class, 'deActivateTeamMember']);
    Route::get('delegates/getAllDelegatesWithQ', [\App\Modules\Auth\Responsible\Controllers\ResponsibleDashboardController::class, 'getAllDelegatesWithQ'])->name('delegates.getList');
    Route::get('responsible/getAllResponsiblesWithQ', [\App\Modules\Auth\Responsible\Controllers\ResponsibleDashboardController::class, 'getAllResponsiblesWithQ'])->name('responsibles.getList');
    Route::get('projectmanagers/getAllProjectManagersWithQ', [\App\Modules\Auth\Responsible\Controllers\ResponsibleDashboardController::class, 'getAllProjectManagersWithQ'])->name('projectnmanagers.getList');
    Route::get('projectmanagers/getAllProjectManagersForProjectWithQ/{project}', [\App\Modules\Auth\Responsible\Controllers\ResponsibleDashboardController::class, 'getAllProjectManagersForProjectWithQ'])->name('.project.projectnmanagers.getList');

//  Users
    Route::resource('users', \App\Modules\User\Controllers\UserDashboardController::class);
    Route::get('user/getAllPersonalReligionsWithQ', [\App\Modules\User\Controllers\UserDashboardController::class, 'getAllPersonalReligionsWithQ']);
    Route::get('user/getAllRecordReligionsWithQ', [\App\Modules\User\Controllers\UserDashboardController::class, 'getAllRecordReligionsWithQ']);
    Route::get('user/getAllUsersMunicipalitiesWithQ', [\App\Modules\User\Controllers\UserDashboardController::class, 'getAllUsersMunicipalitiesWithQ']);
    Route::get('user/getAllNationalitiesWithQ', [\App\Modules\User\Controllers\UserDashboardController::class, 'getAllNationalitiesWithQ']);
    Route::get('user/getAllUsersWithQ', [\App\Modules\User\Controllers\UserDashboardController::class, 'getAllUsersWithQ']);
    Route::get('user/getAllUsersMunicipalities', [\App\Modules\User\Controllers\UserDashboardController::class, 'getAllUsersMunicipalities']);
    Route::delete('user/{user}', [\App\Modules\User\Controllers\UserDashboardController::class, 'destroyTempUser'])->name('tempUser.destroy');
    Route::delete('user/immigrant/{user}/{election}', [\App\Modules\User\Controllers\UserDashboardController::class, 'immigrantTempUser'])->name('tempUser.immigrant');
    Route::delete('user/localize/{user}/{election}', [\App\Modules\User\Controllers\UserDashboardController::class, 'localizeTempUser'])->name('tempUser.localize');
    Route::post('user/import/{election}/store', [\App\Modules\User\Controllers\UserDashboardController::class, 'storeImportedCitizens'])->name('users.import.store');
    Route::post('user/import/{election}/sync', [\App\Modules\User\Controllers\UserDashboardController::class, 'syncImportedCitizens'])->name('users.import.sync');
    Route::get('election/{election}/users/index', [\App\Modules\User\Controllers\UserDashboardController::class, 'indexForElections'])->name('users.index.forelection');
    Route::post('election/{election}/assignToResponsible', [\App\Modules\User\Controllers\UserDashboardController::class, 'assignToResponsible'])->name('election.user.assignToResponsible');
    Route::post('citizen/{election}/changeColor', [\App\Modules\User\Controllers\UserDashboardController::class, 'changeColor'])->name('election.user.changeColor');

//  Projects & Tasks
    Route::resource('projects', \App\Modules\Project\Controllers\ProjectDashboardController::class);
    Route::get('projecttypes/getAllProjectTypesWithQ', [\App\Modules\Project\Controllers\ProjectDashboardController::class, 'getAllProjectTypesWithQ']);
    Route::get('statuses/getAllStatusesWithQ', [\App\Modules\Project\Controllers\ProjectDashboardController::class, 'getAllStatusesWithQ']);
    Route::get('project/indexByResponsible/{responsible}', [\App\Modules\Project\Controllers\ProjectDashboardController::class, 'indexByResponsible'])->name('projects.indexByResponsible');
    Route::get('project/indexByUser/{user}', [\App\Modules\Project\Controllers\ProjectDashboardController::class, 'indexByUser'])->name('projects.indexByUser');
    Route::get('project/list', [\App\Modules\Project\Controllers\ProjectDashboardController::class, 'indexQProjects'])->name('projects.getList');
    Route::post('tasks/store', [\App\Modules\Task\Controllers\TaskDashboardController::class, 'store'])->name('tasks.store');
    Route::put('tasks/update/{task}', [\App\Modules\Task\Controllers\TaskDashboardController::class, 'update'])->name('tasks.update');
    Route::delete('tasks/destroy/{task}', [\App\Modules\Task\Controllers\TaskDashboardController::class, 'destroy'])->name('tasks.destroy');
    Route::get('tasks/byProject/{project}', [\App\Modules\Task\Controllers\TaskDashboardController::class, 'indexByProject'])->name('tasks.byProject');

//  Notifications
    Route::resource('notifications', \App\Modules\Auth\Notification\Controllers\NotificationDashboardController::class);
    Route::get('notify', [\App\Modules\Auth\Notification\Controllers\NotificationDashboardController::class, 'notifiedIndex'])->name('notify.responsibles');

//  Settings
    Route::resource('statuses', \App\Modules\Status\Controllers\StatusDashboardController::class);

//  Elections
    Route::resource('elections', \App\Modules\Election\Controllers\ElectionDashboardController::class);
    Route::get('getActiveElectionLiveStream', [\App\Modules\Election\Controllers\ElectionDashboardController::class, 'getActiveElectionLiveStream'])->name('elections.livestream');
    Route::delete('election/{election}/activate', [\App\Modules\Election\Controllers\ElectionDashboardController::class, 'activate'])->name('elections.activate');
    Route::delete('election/{election}/deactivate', [\App\Modules\Election\Controllers\ElectionDashboardController::class, 'deactivate'])->name('elections.deactivate');
    Route::delete('election/{election}/reset', [\App\Modules\Election\Controllers\ElectionDashboardController::class, 'reset'])->name('elections.reset');
    Route::get('election/user/{user}/prevElections/list', [\App\Modules\Election\Controllers\ElectionDashboardController::class, 'indexListPrevElections'])->name('election.user.indexList');

    // Parties
    Route::resource('parties', \App\Modules\Party\Controllers\PartyDashboardController::class);
    Route::delete('party/{party}/{election}', [\App\Modules\Party\Controllers\PartyDashboardController::class, 'destroyByElection'])->name('parties.destroyByElection');
    Route::get('election/{election}/parties', [\App\Modules\Party\Controllers\PartyDashboardController::class, 'indexByElection'])->name('candidates.indexByElection');
    Route::post('election/{election}/reorderElectionParties', [\App\Modules\Party\Controllers\PartyDashboardController::class, 'reorderElectionParties'])->name('parties.reorderElectionParties');


    // Boxes
    Route::resource('boxes', \App\Modules\Box\Controllers\BoxDashboardController::class);
    Route::get('election/{election}/boxes/index', [\App\Modules\Box\Controllers\BoxDashboardController::class, 'indexListByElection'])->name('boxes.indexListByElection');
    Route::get('election/active/boxes', [\App\Modules\Box\Controllers\BoxDashboardController::class, 'indexListByActiveElection'])->name('boxes.indexListByActiveElection');
    Route::get('box/{box}/citizens/list', [\App\Modules\User\Controllers\UserDashboardController::class, 'indexByBox'])->name('boxes.indexCitizens.list');
    Route::get('box/index/{election}/close-requests', [\App\Modules\Box\Controllers\BoxDashboardController::class, 'indexListForCloseRequests'])->name('boxes.close.requests');
    Route::delete('box/{box}/close', [\App\Modules\Box\Controllers\BoxDashboardController::class, 'closeBox'])->name('box.close');
    Route::delete('box/{box}/open', [\App\Modules\Box\Controllers\BoxDashboardController::class, 'openBox'])->name('box.open');
    Route::delete('box/{box}/reset', [\App\Modules\Box\Controllers\BoxDashboardController::class, 'reset'])->name('box.reset');

    // Candidates
//  Route::resource('candidates', \App\Modules\Candidate\Controllers\CandidateDashboardController::class);
    Route::post('candidate/{candidate}', [\App\Modules\Candidate\Controllers\CandidateDashboardController::class, 'update'])->name('candidates.update');
    Route::delete('candidate/{candidate}', [\App\Modules\Candidate\Controllers\CandidateDashboardController::class, 'destroy'])->name('candidates.destroy');
    Route::get('election/{election}/candidates/index', [\App\Modules\Candidate\Controllers\CandidateDashboardController::class, 'indexListByElection'])->name('candidates.indexListByElection');
    Route::post('candidates/store', [\App\Modules\Candidate\Controllers\CandidateDashboardController::class, 'store'])->name('candidates.store');
    Route::get('election/statistics/download', [\App\Modules\Election\Controllers\ElectionDashboardController::class, 'export'])->name('statistics.download');

    // Municipalities
    Route::resource('municipalities', \App\Modules\Municipality\Controllers\MunicipalityDashboardController::class);
    Route::get('municipality/list', [\App\Modules\Municipality\Controllers\MunicipalityDashboardController::class, 'indexQMunicipalities'])->name('municipalities.getList');
    Route::get('municipality/{municipality}/religions', [\App\Modules\Municipality\Controllers\MunicipalityDashboardController::class, 'getReligions'])->name('municipality.religions');

    // ProjectTypes
    Route::resource('projectTypes', \App\Modules\ProjectType\Controllers\ProjectTypeDashboardController::class);

    // Announcements
    Route::resource('announcements', \App\Modules\Announcement\Controllers\AnnouncementDashboardController::class);


});
