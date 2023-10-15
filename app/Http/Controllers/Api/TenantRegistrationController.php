<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\TenantRegistration;


class TenantRegistrationController extends BaseController
{
    public function index(Request $request)
    {
     	 $data=TenantRegistration::orderby('id','asc')->paginate(5);
		 return $this->successResponse($data);
    }

    public function store(Request $request){
        
        $this->validate($request, TenantRegistration::getRules());
        $result=TenantRegistration::create($request->all()+ ['user_id' => auth()->id()]);
        return $this->successResponse($result, 'Request has been submitted successfully');

    }
}
