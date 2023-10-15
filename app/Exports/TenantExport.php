<?php

namespace App\Exports;

use App\Models\TenantRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TenantExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return TenantRegistration::all();
         return TenantRegistration::select('id','name','property_id','apartment_id','dob','email','emergency_contact','nationality','occupants','occupant_name')
        ->get();
    }

    public function headings() :array
    {
        return ["ID", "Name", "Location ID","Apartment ID", "DOB","Email","Emergency Contact","Nationality","Occupants","Occupant Name"];
    }
}
