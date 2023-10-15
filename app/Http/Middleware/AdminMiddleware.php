<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\Employee;
use App\Helpers\helpers;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::guard('admin')->check()){
            return redirect()->route('admin.login');
        }
		$admin=Employee::find(Auth::guard('admin')->id());
		helpers::$admin=$admin;
		//dd($admin);
		view()->share('adminUser', $admin);
        return $next($request);
    }
}
