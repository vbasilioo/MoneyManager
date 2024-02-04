<?php

namespace App\Utils;

class ApiResponse{
    public static function success($data = null, $message = 'Success.', $statusCode = 200){
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

    public static function error($message = 'Error.', $statusCode = 500){
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }
}