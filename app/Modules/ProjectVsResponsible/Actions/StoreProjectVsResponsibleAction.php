<?php


namespace App\Modules\ProjectVsResponsible\Actions;

use App\Modules\Auth\Notification\Actions\StoreNotificationAction;
use App\Modules\Auth\Notification\DTO\NotificationDTO;
use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Project\Models\Project;
use App\Modules\ProjectVsResponsible\DTO\ProjectVsResponsibleCollection;

class StoreProjectVsResponsibleAction
{
    public static function execute(
        Project                        $project,
        ProjectVsResponsibleCollection $projectVsResponsibleCollection,
                                       $disable_notification = false
    )
    {
        if ($projectVsResponsibleCollection->toArr()) {
            $responsiblesIds = [];
            $notifiedTokens = [];
            foreach ($projectVsResponsibleCollection->toArr() as $responsibleDTO) {
                $selectedId = $responsibleDTO->responsible_id;
                if (!$project->responsibles->find($selectedId)) {
                    if (isset(Responsible::find($selectedId)->fcm_token)) {
                        array_push($notifiedTokens, Responsible::find($selectedId)->fcm_token);
                    }
                }
                array_push($responsiblesIds, $selectedId);
            }
            $project->responsibles()->sync($responsiblesIds);
            if (!$disable_notification) {
                StoreNotificationAction::execute(new NotificationDTO([
                    'title' => 'Project',
                    'body' => 'You Have Been assigned to new project',
                    'responsibles' => $notifiedTokens,
                ]));
            }
        }
    }

}
