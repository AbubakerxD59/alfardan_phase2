<?php

namespace App\Http\Controllers\Admin;

use App\Models\Floor;
use App\Models\Tower;
use App\Models\Property;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\NotificationEmail;
use App\Http\Controllers\Controller;

class NotificationEmailController extends Controller
{
    public function index($id=null){
        $properties = Property::all();
        $apartments = Apartment::all();
        $towers = Tower::all();
        $floors = Floor::all();
        if($id == 'bell'){
            return view('admin.notifications_list')
                ->with('properties', $properties);
        }
        return view('admin.notifications')
            ->with('properties', $properties)
            ->with('apartments', $apartments)
            ->with('towers', $towers)
            ->with('floors', $floors);
    }

    public function listing(Request $request){
        $data = $request->all();
        $search = @$data['search']['value'];
        $order = end($data['order']);
        $orderby = $data['columns'][$order['column']]['data'];
        $iTotalRecords = new NotificationEmail;
        $notifications = NotificationEmail::with('tenant', 'properties', 'apartments');
        if (!empty($search)) {
            $notifications = $notifications->where(function ($q) use ($search) {
                $q->orWhere('message', 'like', '%' . $search . '%');
            });
        }
        $notifications = $notifications->orderBy($orderby, $order['dir']);
        $totalRecordswithFilter = clone $notifications;
        /*Set limit offset */
        $notifications = $notifications->offset(intval($data['start']));
        $notifications = $notifications->limit(intval($data['length']));
        /*Fetch Data*/
        $notifications = $notifications->get();
        foreach ($notifications as $key => $notification) {
            if ($notification->tenant != "" && $notification->tenant != NULL) {
                $notification->user_id = $notification->tenant->full_name;
            } else {
                $notification->user_id = '';
            }
            if ($notification->properties != "" && $notification->properties != NULL) {
                $notification->property_id = $notification->properties->name;
            }
            $notifications[$key]['apartment'] = '';
            $notifications[$key]['detail'] = view('admin.notification_category', compact('notification'))->render();
            $notifications[$key] = $notification;
        }
        return response()->json([
            "draw" => intval($data['draw']),
            "iTotalRecords" => $iTotalRecords->count(),
            "iTotalDisplayRecords" => $totalRecordswithFilter->count(),
            "aaData" => $notifications
        ]);
    }

    public function more_detail(Request $request, $category=null){
        if($category == 'Tenants Registration'){
            return redirect()->route('admin.users.all_requests');
        }
    }
}
