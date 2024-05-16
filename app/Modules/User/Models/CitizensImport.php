<?php

namespace App\Modules\User\Models;

use App\Modules\Election\Models\Election;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CitizensImport implements WithMultipleSheets
{

    protected $election;

    public function __construct(Election $election)
    {
        //
        $this->election = $election;
    }

    public function sheets(): array
    {
        return [
            1 => new FirstSheetImport($this->election),
            2 => new SecondSheetImport($this->election)
        ];
    }
}
