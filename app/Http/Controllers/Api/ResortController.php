<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Resort;
use App\Models\Booking;
use App\Models\User;

class ResortController extends BaseController
{
    public function index(Request $request)
    {

        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $user = User::find($user_id);
            $property = $user->userpropertyrelation->property_id;
            if ($property) {
                $property = strval($property);
            }
            $booked_ids = Booking::where('user_id', $user->id)
                ->whereNotNull('resort_id')
                ->pluck('resort_id')
                ->toArray();
            $booked = Resort::whereIn('id', $booked_ids);
            $rests = array();
            $resorts = Resort::orderBy('order', 'ASC')->get();
            foreach ($resorts as $resort) {
                $property_ids = $resort->property;
                if (in_array($property, $property_ids)) {
                    array_push($rests, $resort);
                }
            }
            $resorts = $rests;
        } else {
            $booked = Resort::where('id', 0);
            $resorts = Resort::orderBy('order', 'ASC');
            $resorts = $resorts->where('status', 1)->get();

        }
        if ($request->has("q")) {

            $resorts->where("name", "like", "%" . $request->input("q") . "%");

            $data = [
                'resorts' => $resorts->get()
            ];

            return $this->successResponse($data);
        }
        $data = [
            'booked' => $booked->get(),
            'resorts' => $resorts
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $resort = Resort::with('images')->where('id', $id)->first();

        return $this->successResponse($resort);
    }

    public function book($id)
    {
        $data = ['resort_id' => $id, 'user_id' => auth()->id()];
        Booking::updateOrCreate($data, $data);

        return $this->successResponse([], 'Resort has been booked successfully');
    }

    public function cancelBooking($id)
    {
        Booking::where(['resort_id' => $id, 'user_id' => auth()->id()])->delete();

        return $this->successResponse([], 'Booking has been cancelled successfully');
    }
}