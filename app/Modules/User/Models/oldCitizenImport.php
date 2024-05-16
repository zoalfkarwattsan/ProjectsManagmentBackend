<?php

namespace App\Modules\User\Models;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;

class oldCitizenImport implements ToCollection
{
    use Importable;

    private $municipality;

    public function __construct($municipality)
    {
        $this->municipality = $municipality;
    }

    public function collection(Collection $rows)
    {
        $arr = [];
        foreach ($rows as $key => $row) {
            if ($key > 0) {
                array_push($arr,
                    [
                        'fname' => $row[0],
                        'mname' => $row[1],
                        'lname' => $row[2],
                        'mother_name' => $row[3],
                        'birth_date' => $row[4],
                        'gender' => $row[5],
                        'personal_religion' => $row[6],
                        'record_religion' => $row[7],
                        'civil_registration' => $row[8],
                        'outdoor' => $row[13] ? 1 : 0,
                        'municipality' => $this->municipality,
//                        'color' => $row[14] ? 'white' : $row[16] ? 'black' : 'grey',
                    ]);
            }
        }
        return $arr;
    }
}
