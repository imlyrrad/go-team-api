<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Api
{


    public function apiSuccess($message, $data = ""): JsonResponse
    {
        // Default API response
        $json_structure = [
            'message' => $message,
            'data' => $data
        ];
        // return
        return response()->json($json_structure);
    }

    public function apiError($message, $status_code)
    {
        // Default API response
        $json_structure = ['message' => $message];
        return response()->json($json_structure, $status_code);
    }

    public function paginate($data, $meta, $message)
    {
        $paginated = [
            'message' => $message,
            'data' => $data,
            'meta' => $meta
        ];
        return response()->json($paginated);
    }
}
