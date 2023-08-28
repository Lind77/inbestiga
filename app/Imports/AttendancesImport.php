<?php

namespace App\Imports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class AttendancesImport implements ToModel, WithHeadingRow
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Attendance([
            'user_id' => $row['id'],
            'date' => $row['fecha'],
            'first_punch' => $row['ingreso'],
            'last_punch' => $row['salida'],
            'weekday' => $row['dia']
        ]);
    }
}
