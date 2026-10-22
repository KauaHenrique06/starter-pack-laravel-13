<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ReturnApi
{
    public static function success(
        mixed $data = null, 
        string $message = null,
        int $status = 200): JsonResponse 
    {
        return response()->json([
            'error' => false,
            'message' => $message,
            'data' => $data
        ], $status);
    }
    
    public static function error(
        mixed $data = null, 
        string $message = null, 
        int $status = 400): JsonResponse 
    {
        return response()->json([
            'error' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
