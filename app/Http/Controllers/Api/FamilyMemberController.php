<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\FamilyMember;
use App\Models\User;
use Mail;
use Validator;
class FamilyMemberController extends BaseController
{
    public function index(Request $request)
    {
        
    }

    public function show($id)
    {
        // $family = FamilyMember::with('images')->where('id', $id)->first();

        // return $this->successResponse($family);
    }

    public function store(Request $request){
		
		$validator = Validator::make($request->all(), [
            'email'       => 'required|email|unique:family_members|unique:users',
        ]);
		if($validator->fails())
		{
			$error_messages = implode(',',$validator->messages()->all());
            $response_array = array(
                    'success' => false,
                    'error' => $error_messages,
                    'error_code' => 101,
                    'error_messages' => $error_messages
            );
			return response()->json($response_array, 200);
			// return response()->json($validated->errors(),200);
		}
    	$request = FamilyMember::create($request->all() + ['refrence_id' => auth()->id()]);
		//echo "<pre>";
		//print_r($request->refrence_id);
		$user=User::find($request->refrence_id);
		//print_r($user);
		//exit;
		Mail::send(
                'emailtemplate.tenant', 
                [
                    'name' =>$request->name,
                    'email'=>$request->email
                     
                ], 
                function($message) use ($user)
                {
                    $message->to($user->email)->subject('Notification-Family Member Registration on Alfardan Living');
                }
          );
		Mail::send(
			'emailtemplate.addfamilymember', 
			[
				'name' =>$user['first_name'] .' '. $user['last_name'],
				'email'=>$request->email

			], 
			function($message) use ($request)
			{
				$message->to($request->email)->subject('Request to add you as family member');
			}
        );
        return $this->successResponse($request, 'Request has been submitted successfully');
    }
}
