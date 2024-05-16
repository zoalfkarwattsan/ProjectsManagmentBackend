<?php

namespace App\Modules\User\Models;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;

class ThirdSheetImport implements ToCollection
{

    public function collection(Collection $rows)
    {

    }
}
