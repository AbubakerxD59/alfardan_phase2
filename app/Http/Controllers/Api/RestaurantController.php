<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Booking;
use App\Models\User;

class RestaurantController extends BaseController
{
    public function index(Request $request)
    {
		if(auth('sanctum')->check()){
			$user_id = auth('sanctum')->user()->id;
			$user = User::find($user_id);
			$property = $user->userpropertyrelation->property_id;
			$property = strval($property);
			$booked_ids = Booking::where('user_id', $user->id)
            ->whereNotNull('restaurant_id')
            ->pluck('restaurant_id')
            ->toArray();
        	$booked = Restaurant::whereIn('id', $booked_ids);
			$rests= array();
			$restaurants = Restaurant::orderBy('order', 'ASC')->get();
			foreach($restaurants as $restaurant){
				$property_ids = $restaurant->property;
				if(in_array($property, $property_ids)){
					array_push($rests, $restaurant);
				}
			}
			$restaurants = $rests;
		}else{
        	$booked = Restaurant::where('id', 0);
			$restaurants = Restaurant::orderBy('order', 'ASC');
			$restaurants=$restaurants->where('status',1)->get();
		}
		
        if($request->has("q")){
           $restaurants->where("name","like","%".$request->input("q")."%");
		   $restaurants->where("name","like","%".$request->input("q")."%");
		   $restaurants=$restaurants->where('status',1)->get();
			 $data = [
                'restaurants' =>  $restaurants->get()
            ];
           return $this->successResponse($data);

        }
		//$restaurants=$restaurants->where('status',1)->get();
		foreach($restaurants as $key=>$val){
			
			$menuname=pathinfo($val->menu1,PATHINFO_FILENAME);
			$menuname = preg_replace('/[0-9]+/', '', $menuname);
			$menuname = str_replace('-', ' ', $menuname);
			$val->menu1_text=!empty($menuname)?$menuname:null;
			
			$menuname=pathinfo($val->menu2,PATHINFO_FILENAME);
			$menuname = preg_replace('/[0-9]+/', '', $menuname);
			$menuname = str_replace('-', ' ', $menuname);
			$val->menu2_text=!empty($menuname)?$menuname:null;
			
			
			$menuname=pathinfo($val->menu3,PATHINFO_FILENAME);
			$menuname = preg_replace('/[0-9]+/', '', $menuname);
			$menuname = str_replace('-', ' ', $menuname);
			$val->menu3_text=!empty($menuname)?$menuname:null;
			
			
			$menuname=pathinfo($val->menu4,PATHINFO_FILENAME);
			$menuname = preg_replace('/[0-9]+/', '', $menuname);
			$menuname = str_replace('-', ' ', $menuname);
			$val->menu4_text=!empty($menuname)?$menuname:null;
			
			//dd($menuname);
		}
		
        $data = [
            'booked' =>$booked->get(),
            'restaurants' =>  $restaurants
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $restaurant = Restaurant::with('images')->where('id', $id)->firstOrFail();

		 
			
			$menuname=pathinfo($restaurant->menu1,PATHINFO_FILENAME);
			$menuname = preg_replace('/[0-9]+/', '', $menuname);
			$menuname = str_replace('-', ' ', $menuname);
			$restaurant->menu1_text=!empty($menuname)?$menuname:null;
			
			$menuname=pathinfo($restaurant->menu2,PATHINFO_FILENAME);
			$menuname = preg_replace('/[0-9]+/', '', $menuname);
			$menuname = str_replace('-', ' ', $menuname);
			$restaurant->menu2_text=!empty($menuname)?$menuname:null;
			
			
			$menuname=pathinfo($restaurant->menu3,PATHINFO_FILENAME);
			$menuname = preg_replace('/[0-9]+/', '', $menuname);
			$menuname = str_replace('-', ' ', $menuname);
			$restaurant->menu3_text=!empty($menuname)?$menuname:null;
			
			
			$menuname=pathinfo($restaurant->menu4,PATHINFO_FILENAME);
			$menuname = preg_replace('/[0-9]+/', '', $menuname);
			$menuname = str_replace('-', ' ', $menuname);
			$restaurant->menu4_text=!empty($menuname)?$menuname:null;
			
			
		 
		
		
        return $this->successResponse($restaurant);
    }

    public function book($id)
    {
        $data = ['restaurant_id' => $id, 'user_id' => auth()->id()];
        Booking::updateOrCreate($data, $data);

        return $this->successResponse([], 'Restaurant has been booked successfully');
    }

    public function cancelBooking($id)
    {
        Booking::where(['restaurant_id' => $id, 'user_id' => auth()->id()])->delete();

        return $this->successResponse([], 'Booking has been cancelled successfully');
    }
}
