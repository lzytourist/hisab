<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

trait ApiResponse
{
    protected function response($success, $message, $data = null, $errors = null, $code = 200): JsonResponse
    {
        return Response::json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'errors' => $errors
        ])->setStatusCode($code);
    }

    public function successResponse($message, $data = null): JsonResponse
    {
        return $this->response(true, $message, $data);
    }

    public function errorResponse($message, $errors = null): JsonResponse
    {
        return $this->response(false, $message, null, $errors);
    }
}
