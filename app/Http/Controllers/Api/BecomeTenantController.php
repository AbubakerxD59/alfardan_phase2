<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\BecomeTenant;
use Illuminate\Support\Facades\Validator;

class BecomeTenantController extends BaseController
{
    public function store(Request $request){
		$validator =  Validator::make($request->all(), [
 
            'email' => 'required|email|max:255|unique:become_tenants',
        ]);
		
		if( $validator->fails())
		{
			return $this->errorResponse($validator->errors()->first());
		}
        $request = BecomeTenant::create($request->all());
        

        return $this->successResponse($request, 'Request has been submitted successfully');
    }
}
