<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function successResponse($data = [], $message = '')
    {
        $response = ['success' => true];

        if ($message) {
            $response['message'] = $message;
        }

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, 200);
    }

    public function errorResponse($message, $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        return response()->json($response, $code);
    }
}
