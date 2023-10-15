<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Update;

class UpdatesController extends BaseController
{
    public function index()
    {
        $update = Update::orderby('id', 'desc')->get();
        $endDate = Carbon::now();
        foreach($update as $val){
            $startDate = Carbon::parse($val->created_at);
            $monthsDifference = $startDate->diffInMonths($endDate);
            if($monthsDifference >= 3){
                $val->status = 0;
                $val->save();
            }
        }
        $data = [
            'updates' => Update::where('status','>',0)->get(),
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $data = Update::where('status','>',0)->where('id',$id)->firstOrFail();

        return $this->successResponse($data);
    }
}
