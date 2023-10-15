<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use DB;
class MaintenanceController extends BaseController
{
    public function requests(Request $request)
    {
		$requests=MaintenanceRequest::where('user_id', auth()->id());
		$requests->orderby('maintenance_requests.type','asc');
		$requests->orderby('maintenance_requests.id','DESC');
		$requests=$requests->with('reviews')->get();
		
		foreach($requests as $key=>$val){
			$requests[$key]->stars=$val->totalreviews();
		}
       $data = [
             'requests' => $requests
		   /*'requests' =>  DB::table('maintenance_requests')
            ->leftjoin('reviews', 'reviews.entity_id', '=', 'maintenance_requests.id')
            ->select('maintenance_requests.*', 'reviews.stars')
		   ->where('maintenance_requests.user_id', auth()->id())
		   ->orderby('maintenance_requests.type','asc')
            ->get()*/
        ];

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
        $details=array(
		'status'=>'cancel'
		);
        MaintenanceRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	public function openRequest($id)
    {
        $details=array(
        'status'=>'open'
        );
        MaintenanceRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request open successfully');
    }
}
