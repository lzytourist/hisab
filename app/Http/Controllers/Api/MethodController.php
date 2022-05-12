<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Method;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $methods = $request->user()
            ->methods()
            ->orderBy('id')
            ->get();

        return $this->successResponse('', [
            'methods' => $methods
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Method $method)
    {
        //
    }

    public function update(Request $request, Method $method)
    {
        //
    }

    public function destroy(Method $method)
    {
        //
    }
}
