<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ApiResponse;

    public function stats(Request $request)
    {
        $user_id = $request->user()->id;

        $currentMonthBalance = $request->user()
            ->balances()
            ->whereMonth('created_at', '=', date('m'))
            ->sum('amount');

        $currentMonthExpense = $request->user()
            ->expenses()
            ->whereMonth('created_at', '=', date('m'))
            ->sum('amount');

        $totalBalance = $request->user()
            ->balances()
            ->sum('amount');

        $totalExpense = $request->user()
            ->expenses()
            ->sum('amount');

        return $this->successResponse('', [
            'balance' => [
                'current' => [
                    'amount' => 'BDT ' . number_format($currentMonthBalance, 2),
                    'period' => date('M')
                ],
                'total' => [
                    'amount' => 'BDT ' . number_format($totalBalance, 2),
                    'period' => 'From ' . $request->user()->registrationMonth() . ' to now',
                ]
            ],
            'expense' => [
                'current' => [
                    'amount' => 'BDT ' . number_format($currentMonthExpense, 2),
                    'period' => date('M')
                ],
                'total' => [
                    'amount' => 'BDT ' . number_format($totalExpense, 2),
                    'period' => 'From ' . $request->user()->registrationMonth() . ' to now',
                ]
            ],
            'account' => [
                'current' => 'BDT ' . number_format($currentMonthBalance - $currentMonthExpense, 2),
                'total' => 'BDT ' . number_format($totalBalance - $totalExpense, 2)
            ]
        ]);
    }
}
