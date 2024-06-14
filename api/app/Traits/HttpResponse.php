<?php

namespace App\Traits;

trait HttpResponse
{
    protected  function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'Request was successful',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($message, $code = 400)
    {
        return response()->json([
            'status' => 'Error has occured',
            'message' => $message,
        ], $code);
    }
}
