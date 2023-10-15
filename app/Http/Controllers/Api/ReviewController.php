<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends BaseController
{
    public function index(Request $request)
    {
        $reviews = Review::with('user')
            ->where([
                'entity_type' => $request->entity_type,
                'entity_id' => $request->entity_id
            ])->orderBy('id', 'DESC')
            ->get();

        $data = [
            'reviews' => $reviews,
        ];

        return $this->successResponse($data);
    }

    public function review(Request $request)
    {
		//Review::where('entity_id',$request->entity_id)->delete();
        Review::create($request->all() + ['user_id' => auth()->id()]);

        return $this->successResponse([], 'Review has been posted successfully');
    }
}
