<?php

namespace App\Http\Controllers\Api;

use App\Models\Hotel;
use App\Models\Resort;
use App\Models\Facility;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Models\PrivilegeProgram;
use App\Models\PrivilegeCategory;
use App\Http\Controllers\Api\BaseController;

class PrivilegeController extends BaseController
{
    public function index(Request $request)
    {
        $categories = PrivilegeCategory::all();
        $category_id = $request->category_id ?: $categories->first()->id;

        if ($category_id == 1) {

            $data = [
                // 'restaurants' => Restaurant::all()
                'restaurants' => Restaurant::where('is_privilege', '1')->get()
            ];

        } else {

            $data = [
                // 'facilities' => Facility::all()
                'facilities' => Facility::where('is_privilege', '1')->get()
            ];
            
        }

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $hotel = MaintenanceRequest::with('images')->where('id', $id)->first();

        return $this->successResponse($hotel);
    }

    public function newRequest(Request $request)
    {
        $maintenance_request = MaintenanceRequest::create($request->all() + ['user_id' => auth()->id()]);

        if ($request->file('images')) {
            $maintenance_request->addImages($request->file('images'));
        }

        $maintenance_request = MaintenanceRequest::with('images')->where('id', $maintenance_request->id)->first();

        return $this->successResponse($maintenance_request, 'Request has been submitted successfully');
    }

    public function cancelRequest($id)
    {
        MaintenanceRequest::where('id', $id)->delete();

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	public function getBrochure(){
        $brochure=PrivilegeProgram::first();
        return $this->successResponse($brochure);
    }

    public function privilege_restaurants(){
        // $restaurants = Restaurant::where('is_privilege', '1')->get();
        $data = [
         'restaurants' => Restaurant::where('is_privilege', '1')->get()
        ];
        return $this->successResponse($data);
    }

    public function privilege_hotels(){
        // $hotels = Hotel::where('is_privilege', '1')->get();
        $data = [
            'hotels' => Hotel::where('is_privilege', '1')->get()
           ];
        return $this->successResponse($data);
    }

    public function privilege_wellness(){
        // $resort = Resort::where('is_privilege', '1')->get();
        $data = [
            'resort' => Resort::where('is_privilege', '1')->get()
           ];
        return $this->successResponse($data);
    }
}
