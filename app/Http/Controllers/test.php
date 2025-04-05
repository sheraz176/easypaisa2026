<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;

class EasypaisaPaymentService
{
    private $clientId;
    private $apiKey;
    private $privateKey;
    private $baseUrl;
    private $appId;
    private $merchantId;
    private $accessToken;

    public function __construct()
    {
        $this->clientId = '06162633350408';
        $this->apiKey = 'f4c887fcd2ea2f82b9b6cab68fe16506';
        $this->privateKey = "-----BEGIN PRIVATE KEY-----\n...\n-----END PRIVATE KEY-----";
        $this->baseUrl = 'https://miniapp-epdev.telenorbank.pk';
        $this->appId = 'savingsapp';
        $this->merchantId = 'savingsapp';
        $this->accessToken = '9d5a1bf90ce07045799d4b27341022b72e5b8735';
    }

    private function generateSignature($data)
    {
        $privateKey = openssl_pkey_get_private($this->privateKey);
        if (!$privateKey) {
            Log::error("Error loading private key.");
            return false;
        }

        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        openssl_free_key($privateKey);

        return urlencode(base64_encode($signature));
    }

    public function createPayment($savingId, $amount)
    {
        $date = new DateTime('now', new DateTimeZone('Asia/Karachi'));
        $requestTime = $date->format("Y-m-d\TH:i:s.vP");

        $data = [
            "merchantID" => $this->merchantId,
            "appID" => $this->appId,
            "paymentOrderTitle" => "Saving Deposit",
            "paymentOrderID" => $savingId,
            "paymentAmount" => $amount
        ];

        $signatureString = "POST /v1/payments/createPayment\n" .
            "{$this->clientId}.{$requestTime}.{$this->accessToken}." . json_encode($data);

        $signature = $this->generateSignature($signatureString);
        if (!$signature) {
            return ['error' => 'Failed to generate signature'];
        }

        $headers = [
            "Request-Time" => $requestTime,
            "Client-Id" => $this->clientId,
            "Signature" => "algorithm=RSA2048, keyVersion=1, signature=$signature",
            "Access-Token" => $this->accessToken,
            "Content-Type" => "application/json"
        ];

        $response = Http::withHeaders($headers)->post($this->baseUrl . '/v1/payments/createPayment', $data);
        return $response->json();
    }

    public function handlePaymentResponse($request)
    {
        DB::beginTransaction();
        try {
            $savingTempId = $request->paymentOrderID;
            $paymentStatus = $request->paymentStatus;
            $failureReason = $request->failureReason ?? 'Unknown error';

            if ($paymentStatus === 'success') {
                $savingData = DB::table('customer_savings_master_temp')->where('id', $savingTempId)->first();
                if (!$savingData) {
                    return response()->json(['error' => 'Invalid saving ID'], 400);
                }

                $savingId = DB::table('customer_savings_master')->insertGetId((array) $savingData);

                DB::table('investment_ledger_saving')->insert([
                    'customer_id' => $savingData->customer_id,
                    'saving_id' => $savingId,
                    'transaction_id' => $request->transaction_id,
                    'amount' => $savingData->initial_deposit,
                    'transaction_type' => 'deposit',
                    'date_time' => now(),
                    'net_amount' => $savingData->initial_deposit,
                    'gross_amount' => $savingData->initial_deposit,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('customer_savings_master_temp')->where('id', $savingTempId)->delete();
                DB::commit();
                return response()->json(['message' => 'Saving successfully started!', 'saving_id' => $savingId], 201);
            } else {
                $savingData = DB::table('customer_savings_master_temp')->where('id', $savingTempId)->first();
                if ($savingData) {
                    DB::table('failed_savings_attempts')->insert([
                        'customer_id' => $savingData->customer_id,
                        'customer_msisdn' => $savingData->customer_msisdn,
                        'initial_deposit' => $savingData->initial_deposit,
                        'tenure_days' => $savingData->tenure_days,
                        'failure_reason' => $failureReason,
                        'transaction_id' => $request->transaction_id ?? null,
                        'saving_status' => 'failed',
                        'attempted_at' => now(),
                    ]);
                }
                DB::table('customer_savings_master_temp')->where('id', $savingTempId)->delete();
                DB::commit();
                return response()->json(['error' => 'Payment Failed. Saving attempt logged.'], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
