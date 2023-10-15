<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;

class ApartmentController extends BaseController
{
    public function index(Request $request)
    {
        $apartments = User::get();
        $apartment_ids = array(); 
        foreach ($apartments as $ids){
            $apartment = Apartment::where('name', 'LIKE', '%'.$ids->apt_number.'%')->first();
            array_push($apartment_ids, $apartment->id);
        }
        $data = [
            'apartments' => Apartment::where('property_id', $request->property_id)->whereNotIn('id', $apartment_ids)->where('status',1)->get()
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $apartment = Apartment::with('images')->where('id', $id)->first();

        return $this->successResponse($apartment);
    }
}
