<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\PetApplication;
use App\Models\MaintenanceAbsentiaRequest;
use App\Models\GuestAccessRequest;
use App\Models\HousekeeperRequest;
use App\Models\VehicleRequest;
use App\Models\AccessKeyRequest;
use App\Models\Concierge;
class  ConciergeController extends BaseController
{
    public function services()
    {
        $data = [
            'history' => ServiceRequest::where(['user_id' => auth()->id()])->orderby('id','desc')->get(),
        ];

        return $this->successResponse($data);
    }

    public function requestService(Request $request)
    {
        ServiceRequest::create($request->all() + ['user_id' => auth()->id()]);

        return $this->successResponse([], 'Service request has been submitted successfully');
    }

    public function petApplication()
    {
        $data = [
            'history' => PetApplication::where(['user_id' => auth()->id()])->orderby('id','desc')->get(),
        ];

        return $this->successResponse($data);
    }

    public function submitPetApplication(Request $request)
    {
        PetApplication::create($request->all() + ['user_id' => auth()->id()]);

        return $this->successResponse([], 'Pet application has been submitted successfully');
    }
	
	 public function getMaintenanceAbsentia()
    {
        $data = [
            'history' => MaintenanceAbsentiaRequest::where(['user_id' => auth()->id()])->orderby('id','desc')->get(),
        ];

        return $this->successResponse($data);
    }
    public function requestMaintenance(Request $request)
    {
        $maintenance_request = MaintenanceAbsentiaRequest::create($request->all() + ['user_id' => auth()->id()]);

        if ($request->file('images')) {
            $maintenance_request->addImages($request->file('images'));
        }

        return $this->successResponse([], 'Maintenance request has been submitted successfully');
    }
	
	public function getGuestAccess()
    {
        $data = [
            'history' => GuestAccessRequest::where(['user_id' => auth()->id()])->get(),
        ];

        return $this->successResponse($data);
    }
    public function guestAccess(Request $request)
    {
        GuestAccessRequest::create($request->all() + ['user_id' => auth()->id()]);

        return $this->successResponse([], 'Guest access form has been submitted successfully');
    }
	
	public function getHousekeeperInformation()
    {
        $data = [
            'history' => HousekeeperRequest::where(['user_id' => auth()->id()])->orderby('id','desc')->get(),
        ];

        return $this->successResponse($data);
    }
	
    public function housekeeperInformation(Request $request)
    {
        HousekeeperRequest::create($request->all() + ['user_id' => auth()->id()]);

        return $this->successResponse([], 'Housekeeper form has been submitted successfully');
    }
	
	public function getVehicleInformation()
    {
        $data = [
            'history' => VehicleRequest::where(['user_id' => auth()->id()])->orderby('id','desc')->get(),
        ];

        return $this->successResponse($data);
    }
	
    public function vehicleInformation(Request $request)
    {
        VehicleRequest::create($request->all() + ['user_id' => auth()->id()]);

        return $this->successResponse([], 'Vehicle form has been submitted successfully');
    }

    public function requestAccessKey(Request $request)
    {
        AccessKeyRequest::create($request->all() + ['user_id' => auth()->id()]);

        return $this->successResponse([], 'Access key card request has been submitted successfully');
    }

    public function accessKey()
    {
        $data = [
            'requests' => AccessKeyRequest::where(['user_id' => auth()->id()])->orderBy('id', 'DESC')->get(),
        ];

        return $this->successResponse($data);
    }
	public function cancelService($id)
    {
        $details=array(
		'status'=>'cancelled'
		);
        ServiceRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	public function openService($id)
    {
        $details=array(
		'status'=>'pending'
		);
        ServiceRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	//////pet request//////
	public function cancelPetRequest($id)
    {
        $details=array(
		'status'=>'cancelled'
		);
        PetApplication::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	public function openPetRequest($id)
    {
        $details=array(
		'status'=>'pending'
		);
        PetApplication::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	////maintenance request///
	public function cancelMaintenanceRequest($id)
    {
        $details=array(
		'status'=>'cancelled'
		);
        MaintenanceAbsentiaRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	public function openMaintenanceRequest($id)
    {
        $details=array(
		'status'=>'pending'
		);
        MaintenanceAbsentiaRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	////guest access request///
	public function cancelGuestAccessRequest($id)
    {
        $details=array(
		'status'=>'cancelled'
		);
        GuestAccessRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	public function openGuestAccessRequest($id)
    {
        $details=array(
		'status'=>'pending'
		);
        GuestAccessRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	////accesskey request////
	public function cancelAccessKeyRequest($id)
    {
        $details=array(
		'status'=>'cancelled'
		);
        AccessKeyRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	public function openAccessKeyRequest($id)
    {
        $details=array(
		'status'=>'pending'
		);
        AccessKeyRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	////vehicle request////
	public function cancelVehicleRequest($id)
    {
        $details=array(
		'status'=>'cancelled'
		);
        VehicleRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	public function openVehicleRequest($id)
    {
        $details=array(
		'status'=>'pending'
		);
        VehicleRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	////housekeeper request///
	public function cancelHousekeeperRequest($id)
    {
        $details=array(
		'status'=>'cancelled'
		);
        HousekeeperRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	public function openHousekeeperRequest($id)
    {
        $details=array(
		'status'=>'pending'
		);
        HousekeeperRequest::where('id', $id)->update($details);

        return $this->successResponse([], 'Request has been cancelled successfully');
    }
	public function getConciergeBanner(){
	$data = [
            'Banner' => Concierge::get(),
        ];

        return $this->successResponse($data);
	
	}
}
