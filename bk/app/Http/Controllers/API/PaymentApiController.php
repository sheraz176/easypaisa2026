<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use App\Models\Slab;
use App\Models\InvestmentLedgerSaving;
use App\Models\EasypaisaUser;
use Illuminate\Support\Facades\Cache;
use App\Models\CustomerSavingsMaster;
use Illuminate\Support\Facades\Validator;

use App\Services\EasypaisaPaymentService;
use Illuminate\Support\Facades\Http;
use App\Jobs\LogPaymentNotificationJob;


class PaymentApiController extends Controller
{

    public function confirmAddFunds(Request $request)
            {
                DB::beginTransaction();
                try {
                    $temporaryAddFundsId = $request->temporaryAddFundsID;
                    $paymentStatus = $request->paymentStatus;
                    $failureReason = $request->failureReason ?? 'Unknown error';
                    $transactionId = $request->transaction_id ?? null;

                    // Fetch the temporary funds addition record
                    $addFundsData = DB::table('temporary_add_funds')->where('id', $request->temporaryAddFundsID)->first();
                    // dd($addFundsData);
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
                        // $this->logInvestmentTransactionaddedfunds($addFundsData, $existingSaving->id, $transactionId);

                        // Remove temporary record
                        // DB::table('temporary_add_funds')->where('id', $temporaryAddFundsId)->delete();

                        DB::commit();

                        // Send external payment notification directly

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

                        // Send external payment notification directly

                        // ExternalPaymentNotifier::logPaymentNotification($requestData, $transactionId);

                        LogPaymentNotificationJob::dispatch($requestData, $transactionId);




                        return response()->json([
                            'message' => 'Funds successfully added!',
                            'saving_id' => $existingSaving->id,
                            'additional_deposit' => $addFundsData->added_funds,
                        ], 201);
                    } else {
                        // Log the failed attempt
                        // $this->logFailedSavingAttempt($addFundsData, $transactionId, $failureReason);

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



    //  public function logPaymentNotification(array $requestData, string $transactionId): void
    // {
    //     Log::info('Starting LogPaymentFunction');
    //        dd('hi');
    //     // Store request data (payload) into the database
    //     $payload = json_encode($requestData);
    //     if ($payload === false) {
    //         Log::error('Failed to encode request data to JSON', [
    //             'transaction_id' => $transactionId,
    //             'error' => json_last_error_msg()
    //         ]);
    //         return;
    //     }

    //     // Initialize Guzzle client
    //     $client = new Client([
    //         'timeout' => 30, // Set a reasonable timeout
    //     ]);

    //     // Set headers
    //     $headers = [
    //         'Authorization' => 'Bearer XXXXAAA123EPDIGITAKAFUL',
    //         'channelcode' => 'EPDIGITAKAFUL',
    //         'Content-Type' => 'application/json',
    //     ];

    //     try {
    //         // Sending synchronous request
    //         Log::info('Sending payment notification request to API');
    //         $response = $client->post('https://api.efulife.com/epay/digi/tkf/sync/payments', [
    //             'json' => $requestData,
    //             'headers' => $headers,
    //         ]);

    //         // Process response
    //         $responseBody = $response->getBody()->getContents();
    //         $statusCode = $response->getStatusCode();

    //         Log::info('Payment Notification Response', [
    //             'status_code' => $statusCode,
    //             'transaction_id' => $transactionId,
    //             'response_body' => $responseBody,
    //         ]);

    //         // Insert into DB with response status
    //         DB::table('external_api_logs')->insert([
    //             'payload' => $payload,
    //             'status' => $statusCode >= 200 && $statusCode < 300 ? 'success' : 'failed', // Success if status is in 2xx range
    //             'response' => $responseBody,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         Log::info('Successfully logged payment notification response into DB');

    //     } catch (RequestException $e) {
    //         // Handle request exception (API failure)
    //         $errorMessage = $e->getMessage();
    //         $response = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null;

    //         Log::error('Payment Notification Failed', [
    //             'error_message' => $errorMessage,
    //             'transaction_id' => $transactionId,
    //             'response' => $response,
    //         ]);

    //         // Insert failure log into DB
    //         DB::table('external_api_logs')->insert([
    //             'payload' => $payload,
    //             'status' => 'failed', // Failed status for any error
    //             'response' => $response ?? $errorMessage,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //         Log::info('Successfully logged payment notification failure into DB');
    //     } catch (\Exception $e) {
    //         // General exception (Unexpected errors)
    //         Log::error('Error in External Payment Notification', [
    //             'error_message' => $e->getMessage(),
    //             'transaction_id' => $transactionId,
    //             'stack_trace' => $e->getTraceAsString(),
    //         ]);

    //         // Insert general exception log into DB
    //         DB::table('external_api_logs')->insert([
    //             'payload' => $payload,
    //             'status' => 'failed', // Failed status for any unexpected exception
    //             'response' => $e->getMessage(),
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //         Log::info('Successfully logged general exception into DB');
    //     }
    // }




}



