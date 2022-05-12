<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BalanceRequest;
use App\Http\Resources\BalanceResource;
use App\Models\Balance;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BalanceController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 15);

        $balances = $request->user()
            ->balances()
            ->orderByDesc('id');

        $total = Cache::rememberForever($this->getTotalCacheKey(), function () use ($balances) {
            return $balances->count();
        });

        $balances = $balances->offset(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return $this->successResponse('', [
            'balances' => BalanceResource::collection($balances),
            'total' => $total,
        ]);
    }

    public function store(BalanceRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $request->user()->balances()->create($data);

            Cache::forget($this->getTotalCacheKey());
        } catch (\Exception $e) {
            return $this->errorResponse('Could not save balance.');
        }

        return $this->successResponse('Balance saved successfully!');
    }

    public function show(Balance $balance): JsonResponse
    {
        return $this->successResponse('', [
            'balance' => new BalanceResource($balance)
        ]);
    }

    public function update(BalanceRequest $request, Balance $balance): JsonResponse
    {
        try {
            if ($balance->getOriginal('user_id') !== $request->user()->id) {
                throw new \Exception('You do not have permission to update this document');
            }

            $data = $request->validated();
            $balance->update($data);
        } catch (\Exception $e) {
            return $this->errorResponse('Could not save balance.');
        }

        return $this->successResponse('Balance saved successfully!');
    }

    public function destroy(Request $request, Balance $balance): JsonResponse
    {
        try {
            if ($balance->getOriginal('user_id') !== $request->user()->id) {
                throw new \Exception('You do not have permission to update this document');
            }

            $balance->delete();

            Cache::forget($this->getTotalCacheKey());
        } catch (\Exception $e) {
            return $this->errorResponse('Balance could not be deleted.');
        }

        return $this->successResponse('Balance deleted successfully!');
    }

    private function getTotalCacheKey(): string
    {
        return 'balances_total_user_' . \request()->user()->id;
    }
}
