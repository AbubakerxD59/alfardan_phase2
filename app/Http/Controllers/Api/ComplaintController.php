<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Complaint;
use DB;
class ComplaintController extends BaseController
{
    public function history()
    {
		
		
		$requests=Complaint::where('user_id', auth()->id());
		$requests->orderby('id','DESC');
		$requests=$requests->with('reviews')->get();
		foreach($requests as $key=>$val){
			$requests[$key]->stars=$val->reviews->avg('stars');
		}
		
		
        $data = [
           /* 'complaints' => Complaint::where(['user_id' => auth()->id()])->get(),
			
			 'complaints' =>  DB::table('complaints')
            ->leftjoin('reviews', 'reviews.entity_id', '=', 'complaints.id')
            ->select('complaints.*', 'reviews.stars')
		   ->where('complaints.user_id', auth()->id())
		   ->orderby('complaints.id','asc')
            ->get()*/
        ];
		$data['complaints']=$requests;
        return $this->successResponse($data);
    }

    public function show($id)
    {
        $complaint = Complaint::with('images')->where('id', $id)->first();

        return $this->successResponse($complaint);
    }

    public function raise(Request $request)
    {
        $complaint = Complaint::create($request->all() + ['user_id' => auth()->id()]);

        if ($request->file('images')) {
            $complaint->addImages($request->file('images'));
        }

        return $this->successResponse([], 'Complaint has been raised successfully');
    }

    public function cancel($id)
    {
        // Complaint::where('id', $id)->delete();
        $details=array(
        'status'=>'cancel'
        );
        Complaint::where('id',$id)->update( $details);

        return $this->successResponse([], 'Complaint has been cancelled successfully');
    }

    public function open($id)
    {
        // Complaint::where('id', $id)->delete();
        $details=array(
        'status'=>'open'
        );
        Complaint::where('id',$id)->update( $details);

        return $this->successResponse([], 'Complaint has been opened successfully');
    }
}
