<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\AdminLoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminLoginRequest $request)
    {	
        if($request->ajax()){
            $user = Admin::where('email', $request->email)->first();
            if(empty($user)){
                $user = Employee::where('email', $request->email)->first();
            }
            if($user->code == $request->code){
                return true;
            }else{
                return false;
            }
        }
		//dd(RouteServiceProvider::ADMIN_HOME);
		$routearray=[];
		$routearray[1]=RouteServiceProvider::ADMIN_HOME;
		$routearray[2]='/admin/newsfeed';
		$routearray[3]='/admin/concierge';
		$routearray[4]='/admin/customer/service/chat';
		$routearray[5]='/admin/properties';
		$routearray[6]='/admin/newsfeed';
		$routearray[7]='/admin/maintenance';
        $request->authenticate();

        $request->session()->regenerate();
		$admin=Employee::find(Auth::guard('admin')->id());
		
 
		return redirect()->intended($routearray[$admin->type]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function verifycode(Request $request){
        $validated = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        $data = [
            "email" => $request->email,
            "password" => $request->password,
        ];
        $code = rand(10000,99999);
        // $code = '12345';
        $user = Admin::where('email', $request->email)->first();
        if(empty($user)){
            $user = Employee::where('email', $request->email)->first();
        }
        if($user){
            // dd(password_verify($request->password, $user->password));
            if (!Hash::check($request->password, $user->password)) {
                return redirect()->back()->with('flash_admin', 'Whoops! Something went wrong. These credentials do not match our records.');
            }
            $user->code = $code;
            $user->save();
            Auth::logout();
            Mail::send('emailtemplate.email_verification_code',['user_data' =>$user, 'otp_code'=>$code],
            function($message) use ($user){
                $message->to('abmasood5900@gmail.com')->subject('Email Verification Code');
                // $message->to($user->email)->subject('Email Verification Code');
            });
            return view('admin.verifyCode')
            ->with('user', $data);
        }
        return redirect()->back()->with('flash_admin', 'Whoops! Something went wrong.
        These credentials do not match our records.');
    }
}
