<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EasypaisaUser;
use App\Models\InvestmentLedgerSaving;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerSavingsMaster;

class WithdrawController extends Controller
{
    public function withdrawSummary(Request $request)
{
    $request->validate([
        'msisdn' => 'required|string'
    ]);

    $msisdn = $request->input('msisdn');

    // Find customer
    $user = EasypaisaUser::where('user_msisdn', $msisdn)->first();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Customer not found'
        ], 404);
    }

    $customerId = $user->id;

    // Total deposits
    $totalDeposit = InvestmentLedgerSaving::where('customer_id', $customerId)
        ->where('transaction_type', 'deposit')
        ->sum('amount');

    // Total withdrawals
    $totalWithdrawal = InvestmentLedgerSaving::where('customer_id', $customerId)
        ->where('transaction_type', 'withdrawal')
        ->sum('amount');

    // Remaining balance (deposit - withdrawal)
    $availableBalance = $totalDeposit - $totalWithdrawal;

    // Profit till last full month
    $endOfLastMonth = Carbon::now()->subMonthNoOverflow()->endOfMonth();
    // $totalProfitTillLastMonth = InvestmentLedgerSaving::where('customer_id', $customerId)
    //     ->where('transaction_type', 'profit')
    //     ->whereDate('date_time', '<=', $endOfLastMonth)
    //     ->sum('amount');
    
    $totalProfitTillLastMonth = InvestmentLedgerSaving::where('customer_id', $customerId)
    ->where('transaction_type', 'profit')
    ->whereDate('date_time', '<=', $endOfLastMonth)
    ->sum('net_amount');

    return response()->json([
        'status' => true,
        'message' => 'Withdraw summary fetched successfully',
        'data' => [
            'msisdn' => $msisdn,
            'total_deposit' => $totalDeposit,
            'total_withdrawal' => $totalWithdrawal,
            'available_balance' => $availableBalance,
            'total_profit_till_last_month' => $totalProfitTillLastMonth
        ]
    ]);
}

//////////////////////////

// public function withdraw(Request $request)
// {
//     $request->validate([
//         'customer_msisdn' => 'required|string',
//         'openid' => 'required|string',
//         'profit_amount' => 'required|numeric|min:0',
//         'withdraw_amount' => 'required|numeric|min:1',
//     ]);

//     // Fetch customer
//     $customer = EasypaisaUser::where([
//         ['user_msisdn', '=', $request->customer_msisdn],
//         ['open_id', '=', $request->openid],
//     ])->first();

//     if (!$customer) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Customer not found.',
//         ], 404);
//     }

//     // Fetch saving record
//     $saving = CustomerSavingsMaster::where('customer_id', $customer->id)
//         ->where('saving_status', 'on-going')
//         ->first();

//     if (!$saving) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Active saving record not found.',
//         ]);
//     }

//     // Aggregate ledger
//     $ledger = InvestmentLedgerSaving::where('customer_id', $customer->id)
//         ->selectRaw("
//             SUM(CASE WHEN transaction_type = 'deposit' THEN amount ELSE 0 END) AS total_deposit,
//             SUM(CASE WHEN transaction_type = 'withdrawal' THEN amount ELSE 0 END) AS total_withdrawal,
//             SUM(CASE WHEN transaction_type = 'profit' AND DATE(date_time) <= ? THEN amount ELSE 0 END) AS profit_till_last_month
//         ", [now()->subMonth()->endOfMonth()])
//         ->first();

//     $availableBalance = $ledger->total_deposit - $ledger->total_withdrawal;
//     $totalProfitTillLastMonth = $ledger->profit_till_last_month;

//     // Zakat check
   

//     // Deposit balance check
//     if ($request->withdraw_amount > $availableBalance) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Insufficient deposit balance.',
//             'available_balance' => number_format($availableBalance, 2),
//         ]);
//     }

//     // Profit balance check
//     if ($request->profit_amount > $totalProfitTillLastMonth) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Insufficient profit balance.',
//             'profit_balance' => number_format($totalProfitTillLastMonth, 2),
//         ]);
//     }

//     //return $saving->zakat_applicable;

//     if ($saving->zakat_applicable == 0) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Zakat exemption form required.',
//             'code' => 'ZAKAT_FORM_REQUIRED',
//         ], 422);
//     }

//     // Transactional withdrawal
//     DB::beginTransaction();
//     try {
//         InvestmentLedgerSaving::create([
//             'customer_id' => $customer->id,
//             'saving_id' => $saving->id,
//             'customer_msisdn' => $request->customer_msisdn,
//             'amount' => $request->withdraw_amount,
//             'transaction_type' => 'withdrawal',
//             'transaction_id' => uniqid('txn_'),
//             'date_time' => now(),
//             'net_amount' => $request->withdraw_amount,
//             'gross_amount' => $request->withdraw_amount,
//         ]);

//         // Deduct from fund growth
//         $saving->fund_growth_amount = max(0, $saving->fund_growth_amount - ($request->profit_amount + $request->withdraw_amount));
//         $saving->save();

//         DB::commit();

//         return response()->json([
//             'status' => true,
//             'message' => 'Withdrawal processed successfully.',
//             'data' => [
//                 'withdraw_amount' => number_format($request->withdraw_amount, 2),
//                 'profit_used' => number_format($request->profit_amount, 2),
//                 'available_balance_after' => number_format($availableBalance - $request->withdraw_amount, 2),
//             ]
//         ]);

//     } catch (\Throwable $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => false,
//             'message' => 'Error processing withdrawal.',
//             'error' => $e->getMessage(),
//         ], 500);
//     }
// }

        public function withdraw(Request $request)
{
    $request->validate([
        'customer_msisdn' => 'required|string',
        'openid' => 'required|string',
        'profit_amount' => 'required|numeric|min:0',
        'withdraw_amount' => 'required|numeric|min:1',
    ]);

    // Fetch customer
    $customer = EasypaisaUser::where([
        ['user_msisdn', '=', $request->customer_msisdn],
        ['open_id', '=', $request->openid],
    ])->first();

    if (!$customer) {
        return response()->json([
            'status' => false,
            'message' => 'Customer not found.',
        ], 404);
    }

    // Fetch saving record
    $saving = CustomerSavingsMaster::where('customer_id', $customer->id)
        ->where('saving_status', 'on-going')
        ->first();

    if (!$saving) {
        return response()->json([
            'status' => false,
            'message' => 'Active saving record not found.',
        ]);
    }

    // Aggregate ledger
    $ledger = InvestmentLedgerSaving::where('customer_id', $customer->id)
        ->selectRaw("
            SUM(CASE WHEN transaction_type = 'deposit' THEN amount ELSE 0 END) AS total_deposit,
            SUM(CASE WHEN transaction_type = 'withdrawal' THEN amount ELSE 0 END) AS total_withdrawal,
            SUM(CASE WHEN transaction_type = 'profit' AND DATE(date_time) <= ? THEN amount ELSE 0 END) AS profit_till_last_month
        ", [now()->subMonth()->endOfMonth()])
        ->first();

    $availableBalance = $ledger->total_deposit - $ledger->total_withdrawal;
    $totalProfitTillLastMonth = $ledger->profit_till_last_month;

    // Deposit balance check
    if ($request->withdraw_amount > $availableBalance) {
        return response()->json([
            'status' => false,
            'message' => 'Insufficient deposit balance.',
            'available_balance' => number_format($availableBalance, 2),
        ]);
    }

    // Profit balance check
    if ($request->profit_amount > $totalProfitTillLastMonth) {
        return response()->json([
            'status' => false,
            'message' => 'Insufficient profit balance.',
            'profit_balance' => number_format($totalProfitTillLastMonth, 2),
        ]);
    }

    // Zakat check
    // if ($saving->is_zakat_applicable == 0) {
    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Zakat exemption form required.',
    //         'code' => 'ZAKAT_FORM_REQUIRED',
    //     ], 422);
    // }

    // Transactional withdrawal
    DB::beginTransaction();
    try {
        // Record the withdrawal
        InvestmentLedgerSaving::create([
            'customer_id' => $customer->id,
            'saving_id' => $saving->id,
            'customer_msisdn' => $request->customer_msisdn,
            'amount' => $request->withdraw_amount,
            'transaction_type' => 'withdrawal',
            'transaction_id' => uniqid('txn_'),
            'date_time' => now(),
            'net_amount' => $request->withdraw_amount,
            'gross_amount' => $request->withdraw_amount,
        ]);

        // Deduct from fund growth
        $saving->fund_growth_amount = max(0, $saving->fund_growth_amount - ($request->profit_amount + $request->withdraw_amount));

        // Determine if this is a full withdrawal
        $remainingBalance = $availableBalance - $request->withdraw_amount;
        if ($remainingBalance <= 0.01) { // treat small remainders as full withdrawal
            $saving->saving_status = 'cancelled';
            $saving->maturity_status = 'terminated';
            $redirect_to = 'start_saving';
        } else {
            $redirect_to = 'active_saving';
        }

        $saving->save();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Withdrawal processed successfully.',
            'data' => [
                'withdraw_amount' => number_format($request->withdraw_amount, 2),
                'profit_used' => number_format($request->profit_amount, 2),
                'available_balance_after' => number_format($remainingBalance, 2),
                'redirect_to' => $redirect_to,
            ]
        ]);

    } catch (\Throwable $e) {
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => 'Error processing withdrawal.',
            'error' => $e->getMessage(),
        ], 500);
    }
}





}

