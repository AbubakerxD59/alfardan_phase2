<?php

namespace App\Imports;

use App\Models\Floor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FloorsImport implements ToModel, WithHeadingRow
{
    public $status = 0;
    public $tower = 0;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($this->tower != 0) {
            $row['tower_id'] = $this->tower;
        }
        return new Floor([
            'name' => $row['name'],
            'property_id' => $row['property_id'],
            'tower_id' => $row['tower_id'],
            'status' => $this->status,
        ]);
    }
}