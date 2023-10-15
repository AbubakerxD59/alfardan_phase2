<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Models\User;
use App\Models\Employee;
use App\Jobs\ContractEnd;
use Illuminate\Support\Str;
use App\Models\FamilyMember;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Jobs\SendVerificationOTP;
use App\Helpers\NotificationHelper;
use App\Models\UserPropertyRelation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;


class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'first_name' => 'string|max:191',
			'full_name' => 'required|string|max:191',
            //'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
           // 'mobile' => 'required|string|max:255|unique:users',
           // 'telephone' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'dob' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'property' => 'required|string|max:255',
            'apt_number' => 'required|string|max:255',
            // 'term_cond' => 'required',
        ]);
		
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }
		if($request->input('type')=='FAMILY MEMBER'){
			$email=$request->input('email');
			$result=FamilyMember::where('email',$email)->count();
			if(!$result){
				 return $this->errorResponse('Email not valid for family member');
			}
		}
		if($request->input('type')=='FAMILY MEMBER'){
			$email=$request->input('email');
			$result=FamilyMember::where('email',$email)->where('status',0)->count();
			if($result){
				 return $this->errorResponse('Already Received Request Please Wait For Admin Approval! ');
			}
		}
		
       
		//$property_id=Property::where('id',$user->property)->first();
		//$apartment_id=Apartment::where('id',$user->apt_number)->first();
		$user = User::create($request->all());
		
		$details=array(
		'user_id' 		=> $user->id,
		'property_id'	=> $request->property,
		'apartment_id'	=> $request->apt_number,
		'status'		=> 1
		);
		UserPropertyRelation::create($details);
		
        $token = $user->createToken('MyApp')->plainTextToken;

        $data = [
            'token' => $token,
            'user' => $user
        ];

		$employes=Employee::whereIn('type', [1,4,3])->where('property_id','like','%"'.$request->property.'"%')->get();
		$emails=['mmartinez@alfardan.com.qa'];
		foreach($employes as $emailsid){
			$emails[]=$emailsid->email;
		}
		
		Mail::send('emailtemplate.adminaccept',['user'=>$user],
				   function($message) use ($emails){
					   $message->to('afp-me@alfardan.com.qa')->subject(' New Tenant Registration'); 
					   $message->cc($emails);
				   });
				
       return $this->successResponse($data, 'Registered successfully');
    }

    public function login(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string',
            'device_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Invalid Credentials');
        }

        $user = auth()->user();
        $code = rand(10000,99999);
		$user->update(['device_token'=>$request->device_token, 'email_ver_code'=>$code]);
        $token = $user->createToken('MyApp')->plainTextToken;
        if($user->status == '1'){
            Mail::send('emailtemplate.email_verification_code',['otp_code'=>$code, 'user_data' => $user],
            function($message) use ($user){
                // $message->to('abmasood5900@gmail.com')->subject('Alfardan Living App - Verification Code');
                $message->to($user->email)->subject('Alfardan Living App - Verification Code');
            });
        }

        if($user->status == '2'){
            return $this->errorResponse('Your contract has been expired. Please contact Alfardan Team.');
        }

        $data = [
            'token' => $token,
            'user' => $user
        ];

        // Contract End
        $now = strtotime(date('Y-m-d'));
        $email = $user->emai;
        $endDate = strtotime($user->end_date);
        $diff = $endDate - $now; 
        // $diffInSeconds = (int)round($diff/(60*60*24));
        if($diff <= 0){
            $user->status = 2;
            $user->save();
        }
        $m2 = strtotime(date('Y-m-d', $endDate));
        $difference = $m2 - $now;
        $months = date('m', $difference);
        if($months > 0){
            if($months <= '2'){
                $notification = new Notification();
                $type = '1005';
                $title = '';
                $message = 'Your contract is about to expire.';
                $details = array(
                    'type' => $type,
                    'user_id' => $user->id,
                    'status' => 1,
                    'title' => $title,
                    'message' => $message,
                );
                $notification->create($details);
                unset($details['type']);
                unset($details['user_id']);
                // NotificationHelper::pushnotification($title, $message, $request->id, $type);
                Mail::send('emailtemplate.contractend',['user_data' => $user],
                function($message) use ($user){
                    $message->to('attaullah@hiconsolutions.com')->subject('Alfardan Living App - Contract Expiration');
                });
                return $this->successResponse($data, $message); 
            }
        } else {
            $user->status = 2;
            $user->save();
        }
        // Contract End
        $concierge = Concierge::latest()->first();
		$user->concierge_safety_handbook = $concierge->safety;
        return $this->successResponse($data, 'Logged in successfully');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse([], 'Logged out successfully');
    }

    public function forgotPassword(Request $request)
    {
         $user = User::where('email', $request->email)
			->where('status',1)->first();
        
        if (!$user) {
            return $this->errorResponse('User with this email is not found', 200);
        }
		else{
			$password = Str::random(8);;
			$hashed = Hash::make($password);
			 Mail::send(
					'emailtemplate.forgotpassword', 
					[
						'password'=>$password,
						'name'    =>$user['first_name'] .' '. $user['last_name']

					], 
					function($message) use ($user)
					{
						$message->to($user->email)->subject('New Password Request for Alfardan Living Account');
					}
				);
			$details=array(
			'password' => $hashed
			);
			User::where('email', $request->email)->update($details);
			return response()->json([
				'success' =>true,
				'message' => 'New Password has been sent to your email address']);
		}

      
    }

    public function verifyPasswordResetCode(Request $request)
    {
        $user = User::where('password_reset_code', $request->code)->first();
        if ($user) {

            $user->password_reset_code = null;
            $user->generateAuthToken();

            $response = [
                'success' => true,
                'message' => 'Password reset code has been verified successfully',
                'user' => $user
            ];

            return response()->json($response);
        }

        $response = [
            'success' => false,
            'message' => 'Password reset code is incorrect'
        ];

        return response()->json($response);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
		//dd($user);
		if(Hash::check($request->currentpassword,$user->password))
		{	
			$user->update(['password' =>$request->newpassword]);
			$response = [
				'success' => true,
				'message' => 'Password has been changed successfully',
				'user' => $user
			];

			return response()->json($response);
			
		}
		else{
			 return $this->errorResponse('Your current password is not valid!', 200);
		}
    }

    public function sendPhoneVerificationCode()
    {
        //Please Enter Your Details
        $user="A2ZMEDIA"; //your username
        $password="21614839"; //your password
        $mobilenumbers="923350421775"; //enter Mobile numbers comma seperated
        $message = "Test messgae"; //enter Your Message
        $senderid="SMSCountry"; //Your senderid
        $messagetype="N"; //Type Of Your Message
        $DReports="Y"; //Delivery Reports
        $url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
        $message = urlencode($message);
        $ch = curl_init();
        if (!$ch){die("Couldn't initialize a cURL handle");}
        $ret = curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt ($ch, CURLOPT_POSTFIELDS,
        "User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //If you are behind proxy then please uncomment below line and provide your proxy ip with port.
        // $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
        $curlresponse = curl_exec($ch); // execute
        if(curl_errno($ch))
            echo 'curl error : '. curl_error($ch);

        if (empty($ret)) {

            // some kind of an error happened
            die(curl_error($ch));
            curl_close($ch); // close cURL handler

        } else {

            $info = curl_getinfo($ch);
            curl_close($ch); // close cURL handler
            echo $curlresponse; //echo "Message Sent Succesfully" ;
        }
    }

    public function user()
    {
       // $data = [
         //  'user' => auth()->user()
       // ];
     //   $data=User::with('families')->with('petapplications')->with('vehicles')->where('id',auth()->id())->first();
		$data=User::with('families') ->with('petapplications', function ($query) {
        	$query->where('status','=','approved');
    	}) ->with('vehicles', function ($query) {
        	$query->where('status','=','approved');
   		})->where('id',auth()->id())->first();
		
        return $this->successResponse($data);
    }
	public function update_profile(Request $request){

        $validator =  Validator::make($request->all(), [
            'path' => 'image|mimes:jpg,png,jpeg',
            
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        $user = User::where('id',auth()->id())->update($request->except(['images']));
		
		
       
        if($request->hasFile('images')!=''){
           // Image::where('user_id',auth()->id())->delete();

            $file = $request->File('images');
            $image1 = time().$file->getClientOriginalName() ;
            $destinationPath = public_path().'/uploads' ;
            $file->move($destinationPath,$image1);

            $details=array(
                'profile'      =>$image1,
            );
            

          $user = User::where('id',auth()->id())->update($details);
  
        }

        return $this->successResponse($user, 'Profile updated successfully');
    }

    public function checkFamilyMember(Request $request){
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if($user){
            return $this->successResponse($user);
        }
        return $this->errorResponse('Email does not exist.', 404);
    }
}
