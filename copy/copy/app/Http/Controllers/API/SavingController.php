<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slab;
use App\Models\InvestmentLedgerSaving;
use App\Models\EasypaisaUser;
use Illuminate\Support\Facades\Cache;
use App\Models\CustomerSavingsMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Services\EasypaisaPaymentService;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendExternalPaymentNotification;
use Illuminate\Support\Facades\Log;
use App\Helpers\ExternalPaymentNotifier;
use App\Jobs\LogPaymentNotificationJob;





class SavingController extends Controller
{

    //Working Code 
    public function startSaving(Request $request)
    {
        $validated = $request->validate([
            'customer_msisdn'   => 'required|string',
            'customer_open_id'  => 'required|string',
            'initial_deposit'   => 'required|numeric|min:1',
            'tenure_days'       => 'required|integer|min:1',
            'zakat_status'      => 'required', 
            //'transaction_id'    => 'required|string',
        ]);
        
        $validated['zakat_status'] = $validated['zakat_status'] == 1 ? 0 : 1;
    
        DB::beginTransaction();
        try {
            // Fetch Customer ID
            $customer = EasypaisaUser::where('user_msisdn', $validated['customer_msisdn'])->select('id')->first();
            if (!$customer) {
                return response()->json(['error' => 'Customer not found'], 400);
            }
    
            // Fetch Slab with Caching
            $slab = Cache::remember("slab_{$validated['initial_deposit']}", 600, function () use ($validated) {
                return Slab::where('initial_deposit', '<=', $validated['initial_deposit'])
                    ->where('maximum_deposit', '>=', $validated['initial_deposit'])
                    ->select('id')
                    ->first();
            });
    
            if (!$slab) {
                return response()->json(['message' => 'No suitable savings plan found'], 400);
            }
    
            // ✅ Store Saving Temporarily (Pending Payment)
            $savingId = DB::table('temporary_savings')->insertGetId([
                'customer_id'        => $customer->id, 
                'customer_msisdn'    => $validated['customer_msisdn'],
                'customer_union_id'  => $validated['customer_open_id'],
                'initial_deposit'    => $validated['initial_deposit'],
                'plan'               => 'Standard',
                'activated_slab'     => $slab->id,
                'tenure_days'        => $validated['tenure_days'],
                'saving_status'      => 'pending-payment',
                'transaction_id'     => 'No Available',
                'is_zakat_applicable'=> $validated['zakat_status'],
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

    
            DB::commit();

            //return $savingId;
    
            // ✅ Call Payment API using Service Class
            $paymentService = new EasypaisaPaymentService();
            $paymentResponse = $paymentService->createPaymentservice("test".$savingId, $validated['initial_deposit']);
            
            //return $savingId;
            return response()->json([
                'temporary_saving_id' => $savingId,
                'payment_response' => $paymentResponse
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
    public function withdraw(Request $request)
    {
        
    }


    public function handlePaymentResponse(Request $request)
    {
        DB::beginTransaction();
        try {
            $savingTempId = $request->paymentOrderID;
            $paymentStatus = $request->paymentStatus;
            $failureReason = $request->failureReason ?? 'Unknown error';
            $transactionId = $request->transaction_id ?? null;

            // Fetch the temporary saving record
            $savingData = DB::table('temporary_savings')->where('id', $savingTempId)->first();
            if (!$savingData) {
                return response()->json(['error' => 'Invalid saving ID'], 400);
            }

            

            // return $savingData;

            // Fetch customer information from easypaisa_users table
            $customerData = DB::table('easypaisa_users')
                ->where('user_msisdn', $savingData->customer_msisdn)
                ->orWhere('open_id', $savingData->customer_union_id)
                ->first();

            //return $customerData;    

            if (!$customerData) {
                return response()->json(['error' => 'Customer not found in Easypaisa records'], 404);
            }

            if ($paymentStatus === 'success') {
                // Move data from temporary table to the master savings table
                $savingId = $this->createCustomerSaving($savingData);

                // Insert transaction into investment ledger
                $this->logInvestmentTransaction($savingData, $savingId, $transactionId);

                $savingStartDate = \Carbon\Carbon::parse($savingData->created_at);
                $savingEndDate = $savingStartDate->copy()->addDays($savingData->tenure_days);


                $payload = [
                    "status" => 200, // Assuming status is always 200 when sending
                    "saving_data" => true, // Confirming saving data exists
                    "message" => "Redirect to Saving Dashboard", // Message as per response example
                    "exists" => true, // Assuming the customer exists
                    "data" => [
                        "first_name" => $customerData->first_name,
                        "last_name" => $customerData->last_name,
                        "user_msisdn" => $customerData->user_msisdn,
                        "cnic" => $customerData->cnic,
                        "date_of_birth" => $customerData->date_of_birth,
                        "gender" => $customerData->gender,
                        "address" => $customerData->address,
                        "email_address" => $customerData->email_address,
                        "occupation" => "Q17",
                        "open_id" => $customerData->open_id,
                        "city" => "187",
                        "father_name" => $customerData->father_name,
                        "saving_start_date" => $savingStartDate->toDateString(), 
                        "saving_end_date" => $savingEndDate->toDateString(),  
                        "transactions" => [
                            [
                                "gross_amount" => (string) $savingData->initial_deposit,
                                "transaction_type" => "deposit",
                                "date_time" => now()->toDateTimeString(),
                                "transaction_id" => "123242321321321"
                            ]
                        ]
                    ]
                ];
                
                //return $payload;
                // Send request to EFU Life API
                $headers = [
                    'Authorization' => 'Bearer XXXXAAA123EPDIGITAKAFUL',
                    'channelcode'   => 'EPDIGITAKAFUL',
                    'Content-Type'  => 'application/json',
                ];
                
                // Send request to EFU Life API with headers
                $response = Http::withHeaders($headers)->post(
                    'https://api.efulife.com/epay/digi/tkf/policy/issuance', 
                    $payload
                );

                if ($response->successful()) {
                    $responseData = $response->json();

                    if ($responseData['status'] === 'Y') {
                        // Save response data in insurance_data table
                        DB::table('insurance_data')->insert([
                            'customer_id' => $customerData->id,
                            'saving_id' => $savingId,
                            'policy_start_date' => $savingStartDate->toDateString(),
                            'policy_end_date' => $savingEndDate->toDateString(),
                            'eful_policy_number' => $responseData['referanceNo'],
                            'eful_status' => 'Transferred to ILAS',
                            'eful_data1' => json_encode($responseData),
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);

                        // Remove record from temporary table
                        DB::table('temporary_savings')->where('id', $savingTempId)->delete();

                        DB::commit();
                        return response()->json([
                            'message' => 'Saving successfully started and transferred to EFU!',
                            'saving_id' => $savingId,
                            'eful_policy_number' => $responseData['referanceNo']
                        ], 201);
                    } else {
                        DB::rollBack();
                        return $responseData;
                        return response()->json(['error' => 'Policy issuance failed at EFU'], 400);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['error' => 'Failed to communicate with EFU API'], 500);
                }
            } else {
                // Log the failed attempt
                $this->logFailedSavingAttempt($savingData, $transactionId, $failureReason);

                // Remove record from temporary table
                DB::table('temporary_savings')->where('id', $savingTempId)->delete();

                DB::commit();
                return response()->json(['error' => 'Payment Failed. Saving attempt logged.'], 400);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            // if ($e->getCode() == 23000) {
            //     return response()->json([
            //         'response_code' => 23000,
            //         'error' => 'Duplicate Saving Alert',
            //         'message' => 'A saving entry with this Customer Union ID already exists.'
            //     ], 409);
            // }
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }




/**
 * Inserts a new record into the customer_savings_master table.
 */
    private function createCustomerSaving($savingData)
    {
        return DB::table('customer_savings_master')->insertGetId([
            'customer_id' => $savingData->customer_id,
            'customer_msisdn' => $savingData->customer_msisdn,
            'customer_union_id' => $savingData->customer_union_id,
            'initial_deposit' => $savingData->initial_deposit,
            'plan' => $savingData->plan,
            'activated_slab' => $savingData->activated_slab,
            'fund_growth_amount' => $savingData->initial_deposit, // Assuming initial value
            'saving_status' => 'on-going',
            'saving_start_date' => now(),
            'saving_end_date' => now()->addDays($savingData->tenure_days),
            'tenure_days' => $savingData->tenure_days,
            'active_days' => 0,
            'maturity_status' => 'in-progress',
            'is_zakat_applicable' => $savingData->is_zakat_applicable,
            'last_profit_calculated_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        InvestmentLedgerSaving::create([
            'customer_id' => $savingData->customer_id,
            'saving_id' => $savingId->id,
            'transaction_id' => $transactionId,
            'amount' => $savingData->initial_deposit,
            'transaction_type' => 'deposit', // Can be changed dynamically
            'date_time' => now(),
            'net_amount' => $savingData->initial_deposit, // Adjust as per business logic
            'gross_amount' => $savingData->initial_deposit, // Adjust as per business logic
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

/**
 * Logs the investment transaction in investment_ledger_saving.
 */
    private function logInvestmentTransaction($savingData, $savingId, $transactionId)
    {
        DB::table('investment_ledger_saving')->insert([
            'customer_id' => $savingData->customer_id,
            'saving_id' => $savingId,
            'transaction_id' => $transactionId,
            'amount' => $savingData->initial_deposit,
            'transaction_type' => 'deposit',
            'date_time' => now(),
            'net_amount' => $savingData->initial_deposit,
            'gross_amount' => $savingData->initial_deposit,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Logs a failed saving attempt in failed_savings_attempts.
     */
    private function logFailedSavingAttempt($savingData, $transactionId, $failureReason)
    {
        DB::table('failed_savings_attempts')->insert([
            'customer_id' => $savingData->customer_id,
            'customer_msisdn' => $savingData->customer_msisdn,
            'customer_union_id' => $savingData->customer_union_id,
            'initial_deposit' => $savingData->initial_deposit,
            'plan' => $savingData->plan,
            'activated_slab' => $savingData->activated_slab,
            'tenure_days' => $savingData->tenure_days,
            'saving_status' => 'failed',
            'transaction_id' => $transactionId,
            'failure_reason' => $failureReason,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


    public function addFunds(Request $request)
    {
        $validated = $request->validate([
            'customer_msisdn'   => 'required|string',
            'customer_open_id'  => 'required|string',
            'additional_deposit' => 'required|numeric|min:1',
           // 'transaction_id'    => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Fetch Customer ID
            $customer = EasypaisaUser::where('user_msisdn', $validated['customer_msisdn'])->select('id')->first();
            if (!$customer) {
                return response()->json(['error' => 'Customer not found'], 400);
            }

            // Fetch Existing Saving Record
            $existingSaving = DB::table('customer_savings_master')->where('customer_id', $customer->id)
                ->where('saving_status', 'on-going')->first();
            if (!$existingSaving) {
                return response()->json(['error' => 'No ongoing saving found for this customer'], 400);
            }

            //return $existingSaving;

            // Store Temporary Funds Addition Record
            $temporaryAddFundsId = DB::table('temporary_add_funds')->insertGetId([
                'customer_id'        => $customer->id,
                'customer_msisdn'    => $validated['customer_msisdn'],
                'customer_union_id'  => $validated['customer_open_id'],
                'added_funds' => $validated['additional_deposit'],
                'transaction_id'     => "12345678",
                'saving_id'          => $existingSaving->id, // Link to the existing saving
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            DB::commit();

            // Call Payment API using Service Class
            $paymentService = new EasypaisaPaymentService();
            $paymentResponse = $paymentService->createPaymentservice('add-fundsm'.$temporaryAddFundsId, $validated['additional_deposit']);

            return response()->json([
                'temporary_add_funds_id' => $temporaryAddFundsId,
                'payment_response' => $paymentResponse,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }

    


         

            public function confirmAddFunds(Request $request)
{
    DB::beginTransaction();
    try {
        $temporaryAddFundsId = $request->temporaryAddFundsID;
        $paymentStatus = $request->paymentStatus;
        $failureReason = $request->failureReason ?? 'Unknown error';
        $transactionId = $request->transaction_id ?? null;

        // Fetch the temporary funds addition record
        $addFundsData = DB::table('temporary_add_funds')->where('id', $temporaryAddFundsId)->first();
        if (!$addFundsData) {
            return response()->json(['error' => 'Invalid funds addition ID'], 400);
        }

        // Fetch the existing saving record
        $existingSaving = DB::table('customer_savings_master')->where('id', $addFundsData->saving_id)->first();
        if (!$existingSaving) {
            return response()->json(['error' => 'No matching saving found'], 400);
        }

        // Fetch the insurance data for eful_policy_number
        $insuranceData = DB::table('insurance_data')->where('saving_id', $existingSaving->id)->first();

        if ($paymentStatus === 'success') {
            // Update the saving record with the new deposit
            DB::table('customer_savings_master')
                ->where('id', $existingSaving->id)
                ->increment('fund_growth_amount', $addFundsData->added_funds);

            // Log the investment transaction for adding funds
            $this->logInvestmentTransactionaddedfunds($addFundsData, $existingSaving->id, $transactionId);

            // Remove temporary record
            DB::table('temporary_add_funds')->where('id', $temporaryAddFundsId)->delete();

            DB::commit();

            // Send external payment notification directly using Laravel's HTTP client
            $requestData = [
                'customer_id' => $insuranceData->eful_policy_number ?? $existingSaving->customer_id,
                'amount' => (string) $addFundsData->added_funds,
                'transaction_type' => 'Additional deposit',
                'transaction_id' => $transactionId,
                'date_time' => now()->format('Y-m-d H:i:s'),
                'gross_amount' => (string) $addFundsData->added_funds,
            ];

            // Log the request data before sending it
            Log::info('Sending External Payment Notification', [
                'request_data' => $requestData,
            ]);

            // Send the request using Laravel's HTTP client
            $response = Http::withHeaders([
                'Authorization' => 'Bearer XXXXAAA123EPDIGITAKAFUL',
                'channelcode' => 'EPDIGITAKAFUL',
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.efulife.com/epay/digi/tkf/sync/payments', $requestData);

            // Process the response
            $responseBody = $response->body();
            $statusCode = $response->status();

            Log::info('Payment Notification Response', [
                'status_code' => $statusCode,
                'transaction_id' => $transactionId,
                'response_body' => $responseBody,
            ]);

            // Log the response in the database
            DB::table('external_api_logs')->insert([
                'payload' => json_encode($requestData),
                'status' => $statusCode >= 200 && $statusCode < 300 ? 'success' : 'failed',
                'response' => $responseBody,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Funds successfully added!',
                'saving_id' => $existingSaving->id,
                'additional_deposit' => $addFundsData->added_funds,
            ], 201);

        } else {
            // Log the failed attempt
            $this->logFailedSavingAttempt($addFundsData, $transactionId, $failureReason);

            // Remove temporary record
            DB::table('temporary_add_funds')->where('id', $temporaryAddFundsId)->delete();

            DB::commit();
            return response()->json(['error' => 'Payment Failed. Funds addition attempt logged.'], 400);
        }
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
    }
}




            














    private function logInvestmentTransactionaddedfunds($savingData, $savingId, $transactionId)
    {
       // return $savingData;
        DB::table('investment_ledger_saving')->insert([
            'customer_id' => $savingData->customer_id,
            'saving_id' => $savingId,
            'transaction_id' => $transactionId,
            'amount' => $savingData->added_funds,
            'transaction_type' => 'deposit',
            'date_time' => now(),
            'net_amount' => $savingData->added_funds,
            'gross_amount' => $savingData->added_funds,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Logs a failed saving attempt in failed_savings_attempts.
     */
    private function logFailedSavingAttemptaddedfunds($savingData, $transactionId, $failureReason)
    {
        DB::table('failed_savings_attempts')->insert([
            'customer_id' => $savingData->customer_id,
            'customer_msisdn' => $savingData->customer_msisdn,
            'customer_union_id' => $savingData->customer_union_id,
            'initial_deposit' => $savingData->added_funds,
            'plan' => $savingData->plan,
            'activated_slab' => $savingData->activated_slab,
            'tenure_days' => $savingData->tenure_days,
            'saving_status' => 'failed',
            'transaction_id' => $transactionId,
            'failure_reason' => $failureReason,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }




}
