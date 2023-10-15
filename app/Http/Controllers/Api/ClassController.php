<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\ClassEvent;
use App\Models\Booking;

class ClassController extends BaseController
{
    public function index(Request $request)
    {
		 $booked=ClassEvent::join('bookings', 'bookings.class_id', 'classes.id')
                ->whereNotNull('class_id')
                ->where('user_id', auth()->id())
                ->select('classes.*', 'bookings.reservations', 'bookings.time', 'bookings.status')
                ->get();
		//dd($booked);
        $data = [
            'booked' =>$booked,
            'classes' => ClassEvent::with('slots')->where('status',1)->get()
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $class = ClassEvent::with(['images','slots'])->where('id', $id)->first();
		
			foreach($class->slots as $key=>$slot){
				$slot->isavailable=$slot->isavailable;
				$slot->seats_available=$slot->seats_available-$slot->reservations();
				$class->slots[$key]=$slot;
			}
		$class->booked=null;
		if($class->bookings()->count()>0){
			if($class->bookings()->where('user_id',auth()->id())->count()>0){
				$class->booked=$class->bookings()->where('user_id',auth()->id())->get();
			}
		}
		
        return $this->successResponse($class);
    }

    public function book($id, Request $request)
    {
		$class = ClassEvent::find($id);
		if($request->reservations >  $class->seats){
			return response()->json([
				'success' =>false,
				'message' => 'Available Seats'.' '.$class->seats
			]);
		}
        $data = [
            'class_id' => $id,
            'user_id' => auth()->id(),
            'reservations' => $request->reservations,
            'time' => $request->time,
            'slot_id'=>$request->slot_id
        ];

        Booking::updateOrCreate($data, $data);

        
        $class->update(['seats' => $class->seats - $request->reservations]);

        return $this->successResponse([], 'Class has been booked successfully');
    }

    public function cancelBooking($id)
    {
        $booking = Booking::where(['class_id' => $id, 'user_id' => auth()->id()])->first();

        $class = ClassEvent::find($id);
        $class->update(['seats' => $class->seats + $booking->reservations]);

        $booking->delete();

        return $this->successResponse([], 'Booking has been cancelled successfully');
    }
}
