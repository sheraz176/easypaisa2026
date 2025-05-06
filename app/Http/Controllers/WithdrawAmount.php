<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\InvestmentLedgerSaving;

class WithdrawAmount extends Controller
{
    
        public function showWithdrawSummary($customerId)
        {
            // 1. Total Deposits (all-time)
            $totalDeposit = InvestmentLedgerSaving::where('customer_id', $customerId)
                ->where('transaction_type', 'deposit')
                ->sum('amount');

            // 2. Last day of previous month
            $endOfLastMonth = Carbon::now()->subMonthNoOverflow()->endOfMonth();

            // 3. Total Profit till end of last month
            $totalProfitTillLastMonth = InvestmentLedgerSaving::where('customer_id', $customerId)
                ->where('transaction_type', 'profit')
                ->whereDate('date_time', '<=', $endOfLastMonth)
                ->sum('amount');

            return response()->json([
                'total_deposit' => $totalDeposit,
                'total_profit_till_last_month' => $totalProfitTillLastMonth,
            ]);
        }

}
