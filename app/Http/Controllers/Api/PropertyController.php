<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends BaseController
{
    public function index(Request $request)
    {
        $data = [
            'properties' => Property::where('status',1)->orderBy('order', 'ASC')->get()
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $property = Property::with(['images','gallery','p3dview'])->where('id', $id)->first();

        return $this->successResponse($property);
    }
}
