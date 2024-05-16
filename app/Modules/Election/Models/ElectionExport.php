<?php

namespace App\Modules\Election\Models;

use App\Models\User;
use App\Modules\Election\ViewModels\ElectionStatisticsVM;
use Maatwebsite\Excel\Concerns\FromCollection;

class ElectionExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $election = Election::where('active', 1)->first();
        if ($election) {
            return ElectionStatisticsVM::handle($election);
        } else {
            $noData = collect();
            $noData->add(['No Data' => 'No Data']);
            return $noData;
        }
    }
}
