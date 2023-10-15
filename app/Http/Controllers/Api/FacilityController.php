<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Booking;

class FacilityController extends BaseController
{
    public function index(Request $request)
    {
        $data = [
            'booked' => Facility::join('bookings', 'bookings.facility_id', '=', 'facilities.id')
                ->whereNotNull('facility_id')
                ->where('user_id', auth()->id())
                ->select('facilities.*', 'bookings.status')
                ->get(),
            'facilities' => Facility::where('status',1)->get()
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $facility = Facility::with('images')->where('id', $id)->first();

        return $this->successResponse($facility);
    }

    public function book($id,Request $request)
    {
        $data = [
				 'facility_id' => $id, 
				 'user_id' => auth()->id(),
				 'reservations' => $request->reservations,
                 'time' => $request->input('time'),
                 'date' => $request->input('date')
				];
        Booking::updateOrCreate($data, $data);

        return $this->successResponse([], 'Facility has been booked successfully');
    }

    public function cancelBooking($id)
    {
        Booking::where(['facility_id' => $id, 'user_id' => auth()->id()])->delete();

        return $this->successResponse([], 'Booking has been cancelled successfully');
    }
}
