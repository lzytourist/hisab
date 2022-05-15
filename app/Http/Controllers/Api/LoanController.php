<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LoanController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 15);

        $loans = $request->user()
            ->loans()
            ->orderByDesc('id');

        $total = Cache::rememberForever($this->getTotalCacheKey(), function () use ($loans) {
            return $loans->count();
        });

        $loans = $loans->offset(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return $this->successResponse('', [
            'loans' => LoanResource::collection($loans),
            'total' => $total,
        ]);
    }

    public function store(LoanRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $request->user()->loans()->create($data);

            Cache::forget($this->getTotalCacheKey());
        } catch (Exception $e) {
            return $this->errorResponse('Could not save loan.');
        }

        return $this->successResponse('Loan saved successfully!');
    }

    public function show(Loan $loan): JsonResponse
    {
        return $this->successResponse('', [
            'loan' => new LoanResource($loan)
        ]);
    }

    public function update(LoanRequest $request, Loan $loan): JsonResponse
    {
        try {
            if ($loan->getOriginal('user_id') !== $request->user()->id) {
                throw new Exception('You do not have permission to update this document');
            }

            $data = $request->validated();
            $loan->update($data);
        } catch (Exception $e) {
            return $this->errorResponse('Could not save loan.');
        }

        return $this->successResponse('Loan saved successfully!');
    }

    public function destroy(Request $request, Loan $loan): JsonResponse
    {
        try {
            if ($loan->getOriginal('user_id') !== $request->user()->id) {
                throw new Exception('You do not have permission to update this document');
            }

            $loan->delete();

            Cache::forget($this->getTotalCacheKey());
        } catch (Exception $e) {
            return $this->errorResponse('Loan could not be deleted.');
        }

        return $this->successResponse('Loan deleted successfully!');
    }

    private function getTotalCacheKey(): string
    {
        return 'loans_total_user_' . \request()->user()->id;
    }
}
