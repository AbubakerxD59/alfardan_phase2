<?php

namespace App\Imports;

use App\Models\Tower;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TowersImport implements ToModel, WithHeadingRow
{
    public $status = 0;
    public $property = 0;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($this->property != 0) {
            $row['property_id'] = $this->property;
        }
        return new Tower([
            'name' => $row['name'],
            'property_id' => $row['property_id'],
            'status' => $this->status,
        ]);
    }
}