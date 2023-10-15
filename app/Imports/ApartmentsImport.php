<?php

namespace App\Imports;

use App\Models\Apartment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ApartmentsImport implements ToModel, WithHeadingRow
{

    public $status = 0;
    public $floor = 0;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($this->floor != 0) {
            $row['floor_id'] = $this->floor;
        }
        return new Apartment([
            //
            'name' => $row['name'],
            'property_id' => $row['property_id'],
            'tower_id' => $row['tower_id'],
            'floor_id' => $row['floor_id'],
            'status' => $this->status,
        ]);
    }
}