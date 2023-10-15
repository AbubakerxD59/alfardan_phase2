<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;

class EventController extends BaseController
{
    public function index(Request $request)
	{
        

        $data = [
            'booked' => Event::join('bookings', 'bookings.event_id', '=', 'events.id')
                ->whereNotNull('event_id')
                ->where('user_id', auth()->id())
                ->select('events.*', 'bookings.status')->get(),
            'events' => Event::where('status',1)->get()
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $event = Event::with('images')->where('id', $id)->first();

        return $this->successResponse($event);
    }

    public function book($id,Request $request)
    {
        $data = ['event_id' => $id, 'user_id' => auth()->id(),'reservations' => $request->reservations,'time' => $request->time];
        Booking::updateOrCreate($data, $data);

        return $this->successResponse([], 'Event has been booked successfully');
    }

    public function cancelBooking($id)
    {
        Booking::where(['event_id' => $id, 'user_id' => auth()->id()])->delete();

        return $this->successResponse([], 'Booking has been cancelled successfully');
    }
}
