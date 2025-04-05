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
        $this->privateKey = "-----BEGIN PRIVATE KEY-----\n" .
                            "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCfmNNS2/kT7SrhnlnmubaLcn158adMrwekbiQN5fq9Z4fIXKxv9Vy2EvvmV6rJCB/E85XEFqrNEmT3420XPPsgL+YEgqgvmG+n8SGdzZg6Zgb5X+dB9AMWOrvTVT2EeNrCz2rWAhcDQt6Jlh6IwU3MAwqpY7jGW1okZeL8y0d4ysx7r2d6qrtWVr5URVNyUWRlfNfrIxd6nxmY75UaJC/408b2vZXX9HtaK4t5ZSP6vWP+26p69U/L2vouiv+0Rrg+tkOgYNr/tRcqNpCjgicEfLwv7S9k+6sgu/a8BNc1nEnZOE4Pk6vYWLAx3aIQxE5x2VPwOKK3u9Euh+a0Ljn1AgMBAAECggEARQTcbvr+bqWkY8oNawBpd0jeBryA82LGVU/ke7Y3h22chQO+9vQPUhZHpcfH7gR7aLtGy3RaDTGlRKav6NrQZ40PVmgCwAKWVvSq6wmcibTR00qsQhN6ukRQMgatAfsZ8CGvPDnPJfPnNW0ca1vdfxrZo4OixvV+uDrvvQ9UK2Ipo8OjHbTYlF/Kb15vSedMbdB3MD1P3y90biCFRkBBuGTjZE5Lv/VYk35EYUJa1bW7GAOLHmSd8a8TILrRSynIovJ2N6T1swB5jxbPb0RdOtWK4RFOFaUvQq3113bKInvHQ5nGQAXYwGpP5E+UEGUzGI6RCflE1GsVfa42P4TTAQKBgQDTwWWLvAz3luBrWiiO3VXVEWbs3TCW8ApvqxVYOTo4ZZewRPonxJ9JLPqsnD/E0PvbtKAGQZ7+ZqFnfl7Gyh8NOLIRKqPmz7rO3bPabXLX7J7S6X1wM4SXLKAC52+4rYWtOYqJNfn98E+6EWBDjJStd5Kd7tGBE2+P8aqZwbh41QKBgQDA8YUalLAGnR3/KabZ7os/EspXzL72I/Ds76shKOhOLFSkGM8wmQpdnYxH6p2qh6vPmFcuNJtE7YQ/I5dGknB42agghTWP6JndNo7mpJVrY+6NPwc2RQAFYFNxkYTvxIjpZ+cN+q0zXmM/cocoNofvePg0L2ArSpZpqROtU59MoQKBgCL6zZV5qQK1T7ksGYsQEP+zcjcqir5ERNURg+MhAPcUASzDGDe9iTqDTZ156ibPBuvSOKUP7f3EYmFARNO9y8dZWEDxtEWKhydpBC7O6au1kL7yhyAjwoFeg8g3BwOQ1oY4/SORYQyLx//KowZFkMHfAL9KFh2mYkV6/F2N3LVJAoGAbHVXxSFf8dfQTOc1C7y0ObhuVfyaO/LoM8hmAjXkoEz7J2Nq1H6y/PzbJnIUPxAU3JVeLHMV9SEu/e8b0mfvIX/4qo83FLZEB73rhmtuMvfx2SRdAXy4Dk2fmm+ass1fyRTHJWyMgBvG3puarlg5AbyWiX84KB29f5ezn/Mp0QECgYEAgDWbZpf+g2kqWgVWoEiaOo4et0VqKgHqqHqxLYwyyGx9BLCATmKCgmtmA4irp2wR9E+dt6uW6Tbi/0EUtVMJRfw7kqj51HeziDkm3LNOSWppHLrWg8ywO90BYPTIZDebVugE4oaP9L8P7pQBpNXjxSVFQ3Gz9Sv/0kGODpThQdU=\n" .
                            "-----END PRIVATE KEY-----";
        $this->baseUrl = 'https://miniapp-epdev.telenorbank.pk';
        $this->appId = 'savingsapp';
        $this->merchantId = 'savingsapp';
        $this->accessToken = '9d5a1bf90ce07045799d4b27341022b72e5b8735';
    }

    private function generateSignature($data)
    {
       // return $data;
        $privateKey = openssl_pkey_get_private($this->privateKey);
        if (!$privateKey) {
            Log::error("Error loading private key.");
            return false;
        }

        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        openssl_free_key($privateKey);

        return urlencode(base64_encode($signature));
    }

    private function sendRequest($endpoint, $headers, $data)
    {

          // Log the request data
        $url = $this->baseUrl . $endpoint;

        $response = Http::withHeaders([
            "Request-Time"  => $headers['Request-Time'],
            "Client-Id"     => $headers['Client-Id'],
            "Signature"     => $headers['Signature'],
            "Access-Token"  => $headers['Access-Token'],
            "Content-Type"  => "application/json"
        ])->post($url, $data);

        return $response->json();
    }

    public function createPaymentservice($savingId, $amount)
    {
        $date = new DateTime('now', new DateTimeZone('Asia/Karachi'));
        $requestTime = $date->format("Y-m-d\TH:i:s.vP");

        $data = [
            "merchantID" => $this->merchantId,  // Extracted from constructor
            "appID" => $this->appId,
            "paymentOrderTitle" => "EFU-Saving-" . $savingId,
            "paymentOrderID" => (string) $savingId, // Ensuring it's a string
            "paymentAmount" => [
                "currency" => "PKR",
                "value" => (string) 1 // Ensuring it's a string
            ]
        ];

        $signatureString = "POST /v1/payments/createPayment\n" .
            "{$this->clientId}.{$requestTime}.{$this->accessToken}." . json_encode($data);

        $signature = $this->generateSignature($signatureString);
        if (!$signature) {
            return ['error' => 'Failed to generate signature'];
        }

        $params = [
            "Request-Time" => $requestTime,
            "Client-Id" => $this->clientId,
            "Access-Token" => $this->accessToken,
        ];
        //return $data;
        //$signature = $this->generateSignature($signatureString);
        $params['Signature'] = "algorithm=RSA2048, keyVersion=1, signature=$signature";
        $response = $this->sendRequest('/v1/payments/createPayment', $params, $data);


        return response()->json($response);
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
