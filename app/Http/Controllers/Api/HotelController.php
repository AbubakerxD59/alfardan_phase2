<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Booking;

class HotelController extends BaseController
{
    public function index(Request $request)
    {
		if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
			$user = User::find($user_id);
			$property = $user->userpropertyrelation->property_id;
            if($property){
                $property = strval($property);
            }
			$booked_ids = Booking::where('user_id', $user->id)
				->whereNotNull('hotel_id')
				->pluck('hotel_id')
				->toArray();
			$booked = Hotel::whereIn('id', $booked_ids);
            $rests= array();
			$hotels = Hotel::orderBy('order', 'ASC')->get();
			foreach($hotels as $hotel){
				$property_ids = $hotel->property;
				if(in_array($property, $property_ids)){
					array_push($rests, $hotel);
				}
			}
			$hotels = $rests;
		}else{
			$booked = Hotel::where('id', 0);
            $hotels = Hotel::orderBy('order', 'ASC');
			$hotels=$hotels->where('status',1)->get();
        }

        if($request->has("q")){
            $hotels->where("name","like","%".$request->input('q')."%");
            $data = [
                'hotels' =>  $hotels->get()
            ];
            return $this->successResponse($data);
        }  
         
        $data = [
            'booked' => $booked->get(),
            'hotels' =>  $hotels
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $hotel = Hotel::with('images')->where('id', $id)->first();

        return $this->successResponse($hotel);
    }

    public function book($id)
    {
        $data = ['hotel_id' => $id, 'user_id' => auth()->id()];
        Booking::updateOrCreate($data, $data);

        return $this->successResponse([], 'Hotel has been booked successfully');
    }

    public function cancelBooking($id)
    {
        Booking::where(['hotel_id' => $id, 'user_id' => auth()->id()])->delete();

        return $this->successResponse([], 'Booking has been cancelled successfully');
    }
}
