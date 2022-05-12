<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExpenseController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 15);

        $expenses = $request->user()
            ->expenses()
            ->orderByDesc('id');

        $total = Cache::rememberForever($this->getTotalCacheKey(), function () use ($expenses) {
            return $expenses->count();
        });

        $expenses = $expenses->offset(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return $this->successResponse('', [
            'expenses' => ExpenseResource::collection($expenses),
            'total' => $total,
        ]);
    }

    public function store(ExpenseRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $request->user()->expenses()->create($data);

            Cache::forget($this->getTotalCacheKey());
        } catch (\Exception $e) {
            return $this->errorResponse('Could not save expense.');
        }

        return $this->successResponse('Expense saved successfully!');
    }

    public function show(Expense $expense): JsonResponse
    {
        return $this->successResponse('', [
            'expense' => new ExpenseResource($expense)
        ]);
    }

    public function update(ExpenseRequest $request, Expense $expense): JsonResponse
    {
        try {
            if ($expense->getOriginal('user_id') !== $request->user()->id) {
                throw new \Exception('You do not have permission to update this document');
            }

            $data = $request->validated();
            $expense->update($data);
        } catch (\Exception $e) {
            return $this->errorResponse('Could not save expense.');
        }

        return $this->successResponse('Expense saved successfully!');
    }

    public function destroy(Request $request, Expense $expense): JsonResponse
    {
        try {
            if ($expense->getOriginal('user_id') !== $request->user()->id) {
                throw new \Exception('You do not have permission to update this document');
            }

            $expense->delete();

            Cache::forget($this->getTotalCacheKey());
        } catch (\Exception $e) {
            return $this->errorResponse('Expense could not be deleted.');
        }

        return $this->successResponse('Expense deleted successfully!');
    }

    private function getTotalCacheKey(): string
    {
        return 'expenses_total_user_' . \request()->user()->id;
    }
}
