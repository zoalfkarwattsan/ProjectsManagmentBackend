<?php

namespace App\Modules\ProjectVsResponsible\DTO;

use App\Modules\ProjectVsResponsible\DTO\ProjectVsResponsibleDTO;
use Spatie\DataTransferObject\DataTransferObject;

class ProjectVsResponsibleCollection extends DataTransferObject
{
    public array $responsibleIds;

    public static function fromRequest(
        $request
    )
    {
        if ($request->responsible_ids) {
            $responsibleIds = [];
            foreach ($request->responsible_ids as $responsible_id) {
                array_push($responsibleIds,
                    ProjectVsResponsibleDTO::fromRequest($responsible_id));
            }
            return new self([
                'responsibleIds' => $responsibleIds
            ]);
        }
        return new self([
            'responsibleIds' => []
        ]);
    }

    public function toArr()
    {
        return $this->responsibleIds;
    }
}
