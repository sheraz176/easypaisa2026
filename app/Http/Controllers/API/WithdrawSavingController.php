<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DateTime;
use DateTimeZone;
use App\Models\CustomerSavingsMaster;
use App\Models\KiborRate;
use App\Models\Slab;
use App\Models\DailyReturn;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WithdrawSavingController extends Controller
{
    protected $merchantId = 'savingsapp';
    protected $appId = 'savingsapp';
    protected $clientId = '06162633350408';
    protected $accessToken = '9d5a1bf90ce07045799d4b27341022b72e5b8735';
    protected $baseUrl = 'https://miniapp-epdev.telenorbank.pk'; // Replace with your actual base URL
    protected $publicKey = "-----BEGIN PUBLIC KEY-----\n".
    "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqK7nJ9pZy6iMZhzqWzTeZ
    +M0J+T3yLXe9xZQ4JXh5LRR4dBfQEgO2uOuOf4cD/AYd1J/2ujL0JmOzy5jwfo9l
    Nl7l4FUBztoerE5NQhJHBL9HZpext0jfy50zA6HrqC+0scwWwq7VJ9uo/KtBf6ndX
    VJeKLfVr/1pFbM6wr98hDtV5HCUlXZGpPt4OUgqlsBBL88mlQ0p4BLFZ9kfr0aEO
    gbh0fiM1uy4lg3A1OB26I+xtsj5CCB6cYnJHgr1f3+U4k5r7ZLUwX6Tw2SwvSvrj
    gnmrn6NmaBq9xwSIsq6VfE9TXnfo1CHn2Ae7F1T+qG6T7gd/MzkrQAvUR+a42z+m
    IQIDAQAB=\n".
    "-----END PUBLIC KEY-----";

    protected $privateKey = "-----BEGIN PRIVATE KEY-----\n" .
                            "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCfmNNS2/kT7SrhnlnmubaLcn158adMrwekbiQN5fq9Z4fIXKxv9Vy2EvvmV6rJCB/E85XEFqrNEmT3420XPPsgL+YEgqgvmG+n8SGdzZg6Zgb5X+dB9AMWOrvTVT2EeNrCz2rWAhcDQt6Jlh6IwU3MAwqpY7jGW1okZeL8y0d4ysx7r2d6qrtWVr5URVNyUWRlfNfrIxd6nxmY75UaJC/408b2vZXX9HtaK4t5ZSP6vWP+26p69U/L2vouiv+0Rrg+tkOgYNr/tRcqNpCjgicEfLwv7S9k+6sgu/a8BNc1nEnZOE4Pk6vYWLAx3aIQxE5x2VPwOKK3u9Euh+a0Ljn1AgMBAAECggEARQTcbvr+bqWkY8oNawBpd0jeBryA82LGVU/ke7Y3h22chQO+9vQPUhZHpcfH7gR7aLtGy3RaDTGlRKav6NrQZ40PVmgCwAKWVvSq6wmcibTR00qsQhN6ukRQMgatAfsZ8CGvPDnPJfPnNW0ca1vdfxrZo4OixvV+uDrvvQ9UK2Ipo8OjHbTYlF/Kb15vSedMbdB3MD1P3y90biCFRkBBuGTjZE5Lv/VYk35EYUJa1bW7GAOLHmSd8a8TILrRSynIovJ2N6T1swB5jxbPb0RdOtWK4RFOFaUvQq3113bKInvHQ5nGQAXYwGpP5E+UEGUzGI6RCflE1GsVfa42P4TTAQKBgQDTwWWLvAz3luBrWiiO3VXVEWbs3TCW8ApvqxVYOTo4ZZewRPonxJ9JLPqsnD/E0PvbtKAGQZ7+ZqFnfl7Gyh8NOLIRKqPmz7rO3bPabXLX7J7S6X1wM4SXLKAC52+4rYWtOYqJNfn98E+6EWBDjJStd5Kd7tGBE2+P8aqZwbh41QKBgQDA8YUalLAGnR3/KabZ7os/EspXzL72I/Ds76shKOhOLFSkGM8wmQpdnYxH6p2qh6vPmFcuNJtE7YQ/I5dGknB42agghTWP6JndNo7mpJVrY+6NPwc2RQAFYFNxkYTvxIjpZ+cN+q0zXmM/cocoNofvePg0L2ArSpZpqROtU59MoQKBgCL6zZV5qQK1T7ksGYsQEP+zcjcqir5ERNURg+MhAPcUASzDGDe9iTqDTZ156ibPBuvSOKUP7f3EYmFARNO9y8dZWEDxtEWKhydpBC7O6au1kL7yhyAjwoFeg8g3BwOQ1oY4/SORYQyLx//KowZFkMHfAL9KFh2mYkV6/F2N3LVJAoGAbHVXxSFf8dfQTOc1C7y0ObhuVfyaO/LoM8hmAjXkoEz7J2Nq1H6y/PzbJnIUPxAU3JVeLHMV9SEu/e8b0mfvIX/4qo83FLZEB73rhmtuMvfx2SRdAXy4Dk2fmm+ass1fyRTHJWyMgBvG3puarlg5AbyWiX84KB29f5ezn/Mp0QECgYEAgDWbZpf+g2kqWgVWoEiaOo4et0VqKgHqqHqxLYwyyGx9BLCATmKCgmtmA4irp2wR9E+dt6uW6Tbi/0EUtVMJRfw7kqj51HeziDkm3LNOSWppHLrWg8ywO90BYPTIZDebVugE4oaP9L8P7pQBpNXjxSVFQ3Gz9Sv/0kGODpThQdU=\n" .
                            "-----END PRIVATE KEY-----";

    public function cashDepositRequest(Request $request)
{
    $requestData = $request->all();

    // 1. Prepare payload
    $payload = [
        "merchantId" => $this->merchantId,
        "appId" => $this->appId,
        "paymentAmount" => [
            "currency" => "PKR",
            "value" => $requestData['amount']
        ],
        "orderId" => $requestData['orderId'],
        "credentials" => $this->aesEncrypt('teststore:Pakistan@123'), // Encrypted credentials
        "extendInfo" => $requestData['extendInfo'] ?? '',
        "merchantMsisdn" => $requestData['merchantMsisdn'],
        "msisdn" => $requestData['msisdn'],
        "openId" => $requestData['openId'],
        "transactionDesc" => $requestData['transactionDesc'] ?? ''
    ];

    // 2. Generate headers
    //$requestTime = now()->format('Y-m-d\TH:i:s\Z');
    $dataToSign = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $signature = $this->generateSignatureCashDeposit($dataToSign);
    $encryptHeader = $this->generateEncryptHeader();

    //return $encryptHeader;
    $date = new DateTime('now', new DateTimeZone('Asia/Karachi')); // Set to Pakistan Time (UTC+5)
    $requestTime = $date->format("Y-m-d\TH:i:s.vP");

    $headers = [
        "Request-Time" => $requestTime,
        "Client-Id" => $this->clientId,
        "Signature" => $signature,
        "Access-Token" => $this->accessToken,
        "Encrypt" => "algorithm=RSA_AES,keyVersion=1,symmetricKey=nysKMSR01HhHDZFm0WMZ%2BLg%2BiPyze%2FYtYq9XCNZLjTJ7WVjCdUVTDF6euM6rIO9UitAM28R6TkrANV23cjVaoUh5np96mFjhW%2F5sbbH9ZjC0QrvWTchiZpBIJHvFT5TJD9ca27CHgF6yDv7geL79W7XYoT%2FWLUyuy9UUcDZMdLVbpQnPGj1KM3M7p6z7q%2FXMQZtWklbIPTxdZeXVoNGsj7EIuWKhPxjC9Tlbx5yv5b08jkqHEj%2FFWUlkLdBGqH0v19l1d9DV5Jpo5Zk6k1SQLck2tpZh94me%2FWVLmlKFVMxSRKkdJNcpyuaIs80JPUpJBs4nB%2FRtDLI7Gt%2FsS79K%2BA%3D%3D",
        "Content-Type" => "application/json"
    ];

    // 3. Send Request
    $endpoint = '/v1/payments/cashDeposit';

    try {
       
        echo json_encode([
            'request_headers' => $headers,
            'request_payload' => $payload
        ], JSON_PRETTY_PRINT);
   

        $response = Http::withHeaders($headers)->post($this->baseUrl . $endpoint, $payload);
        return response()->json($response->json(), $response->status());
    } catch (\Exception $e) {
        Log::error('Cash Deposit Request Error: ' . $e->getMessage());
        return response()->json(['error' => 'Request failed', 'details' => $e->getMessage()], 500);
    }
}


    public function dailyprofit(Request $request)
    {
    
        $customerSavings = CustomerSavingsMaster::where('saving_status', 'on-going')
            ->where('maturity_status', 'in-progress')
            ->get();

        // Loop through each customer saving record
        foreach ($customerSavings as $saving) {

            // Get policy rate (from KiborRate table)
            $policyRate = KiborRate::where('effective_date', '<=', Carbon::today())
                ->orderBy('effective_date', 'desc')
                ->first()->kibor_rate;

            // Get slab based on the initial deposit
            $slab = Slab::where('initial_deposit', '<=', $saving->initial_deposit)
                ->where('maximum_deposit', '>=', $saving->initial_deposit)
                ->first();

            if ($slab) {
                // Daily Return Rate based on slab
                $slabRate = $slab->daily_return_rate;
            } else {
                // If no slab found, default return rate can be applied
                $slabRate = 0;
            }

            // Calculate daily profit
    
            
            $fundGrowthRate = round(pow(1 + ($policyRate / 100), 1 / 365) - 1, 8);
            $customerReturnRate = round(pow(1 + ($slabRate / 100), 1 / 365) - 1, 8);
            $efuLifeRate = round(pow(1 + (1 / 100), 1 / 365) - 1, 8); // Placeholder rate for EFU life
            $easypaisaRate = round($fundGrowthRate - $customerReturnRate - $efuLifeRate, 8);

            
            // Now calculate % contribution of each in fundGrowthRate
            $totalComponents = $customerReturnRate + $efuLifeRate + $easypaisaRate;

            // Avoid division by zero
            if ($totalComponents != 0) {
                $customerReturnPercent = round(($customerReturnRate / $totalComponents) * 100, 3);
                $efuLifePercent = round(($efuLifeRate / $totalComponents) * 100, 3);
                $easypaisaPercent = round(($easypaisaRate / $totalComponents) * 100, 3);
            } else {
                $customerReturnPercent = $efuLifePercent = $easypaisaPercent = 0;
            }


            // Initialize values
                $cumulativeAmount = round($saving->initial_deposit, 3);
                $sumAssured = round($cumulativeAmount * 1.25, 3);

            // Initialize result variables
                $results = [];
                $dailyProfit = 0;
            
                $fundGrowthAmount = round($cumulativeAmount * $fundGrowthRate, 3);
                $efuLifeReturn = round($cumulativeAmount * $efuLifeRate, 3);
                $easypaisaReturn = round($cumulativeAmount * $easypaisaRate, 3);
                $customerReturnAmount = round($cumulativeAmount * $customerReturnRate, 3);


                // Sum at risk and mortality charge calculations
                $sumAtRisk = round(max(0, $sumAssured - $cumulativeAmount), 3);
                $mortalityCharge = round(($sumAtRisk * 0.8 / 1000) / 365, 3);
                $ptfShare = round($mortalityCharge, 3);
                $osfShare = round($efuLifeReturn - $mortalityCharge, 3);

                // Final daily profit for customer
                $dailyProfit = round($customerReturnAmount, 3);

                $newFundGrowthAmount = $saving->fund_growth_amount + $dailyProfit;
                $saving->update(['fund_growth_amount' => $newFundGrowthAmount]);

                 $lastNetAmount = DB::table('investment_ledger_saving')
                    ->where('saving_id', $saving->id)
                    ->orderBy('date_time', 'desc')
                    ->value('net_amount');

                // Default to 0 if no previous record
                $lastNetAmount = $lastNetAmount ?? 0;

                $currentNetAmount = $lastNetAmount + $dailyProfit;

                $investmentLedgerData = [
                    'customer_id' => $saving->customer_id,
                    'saving_id' => $saving->id,
                    'transaction_id' => uniqid('profit_'), // We'll update this after insert
                    'amount' => $dailyProfit,
                    'transaction_type' => 'profit',
                    'date_time' => Carbon::now(),
                    'net_amount' => $currentNetAmount,
                    'gross_amount' => $dailyProfit,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                
                // Insert and get the ID
                $investmentLedgerId = DB::table('investment_ledger_saving')->insertGetId($investmentLedgerData);    
               
           // return $dailyReturnData;   

            // Prepare data to insert into daily_return table
            $dailyReturnData = [
                'customer_id' => $saving->customer_id,
                'date' => Carbon::today()->toDateString(),
                'saving_id'=>$saving->id,
                'investment_ledger_saving_id'=>$investmentLedgerId,
                'customer_msisdn' => $saving->customer_msisdn,
                'customer_union_id' => $saving->customer_union_id,
                'initial_deposit' => $saving->initial_deposit,
                'fund_growth_amount' => $fundGrowthAmount,  // Assuming no extra fund growth calculation for now
                'saving_status' => 'on-going',
                'saving_start_date' => $saving->saving_start_date,
                'saving_end_date' => $saving->saving_end_date,
                'amount_earned' => $dailyProfit,
                'commulative_amount' => $newFundGrowthAmount,
                //'fund_growth_amount' => $dailyProfit,
                'efu_share' => $efuLifeReturn,  // Placeholder percentage for EFU share
                'easypaisa_share' => $easypaisaReturn, // Placeholder percentage for Easypaisa share
                'customer_share' => $customerReturnAmount,  // Placeholder percentage for customer share
                'sum_assured' => $saving->initial_deposit * 1.25, // Assuming 25% as sum assured
                'sum_at_risk' => max(0, ($saving->initial_deposit * 1.25) - $saving->initial_deposit),
                'mortality_charges' => $mortalityCharge, // Placeholder mortality charges calculation
                'ptf_share' => $ptfShare, // Placeholder percentage for PTF share
                'osf_share' => $osfShare, // Placeholder percentage for OSF share
                'type' => 'profit', // For profit type
                'todays_interest_rate' => $slabRate,
                'easypaisa_share_percentage' => $easypaisaRate, // Placeholder percentage for Easypaisa share
                'efu_share_percentage' => $efuLifeRate, // Placeholder percentage for EFU share
                'customer_share_percentage' => $customerReturnRate, // Placeholder percentage for customer share
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Insert daily return data into the daily_return table
            //echo $dailyReturnData; 
            //dd($dailyReturnData);

            $dailyReturn=DailyReturn::create($dailyReturnData);


            //

            $apiData = [
                'id' => $dailyReturn->id,
                'date' => $dailyReturn->date,
                'customer_id' => $dailyReturn->customer_id,
                'saving_id' => $dailyReturn->saving_id,
                'investment_ledger_saving_id' => $dailyReturn->investment_ledger_saving_id,
                'amount_earned' => $dailyReturn->amount_earned,
                'commulative_amount' => $dailyReturn->commulative_amount,
                'fund_growth_amount' => $dailyReturn->fund_growth_amount,
                'efu_share' => $dailyReturn->efu_share,
                'easypaisa_share' => $dailyReturn->easypaisa_share,
                'customer_share' => $dailyReturn->customer_share,
                'sum_assured' => $dailyReturn->sum_assured,
                'sum_at_risk' => $dailyReturn->sum_at_risk,
                'mortality_charges' => $dailyReturn->mortality_charges,
                'ptf_share' => $dailyReturn->ptf_share,
                'osf_share' => $dailyReturn->osf_share,
                'type' => $dailyReturn->type,
                'todays_interest_rate' => $dailyReturn->todays_interest_rate,
                'easypaisa_share_percentage' => $dailyReturn->easypaisa_share_percentage,
                'efu_share_percentage' => $dailyReturn->efu_share_percentage,
                'customer_share_percentage' => $dailyReturn->customer_share_percentage,
                'created_at' => $dailyReturn->created_at,
                'updated_at' => $dailyReturn->updated_at
            ];
    
            $responseData['data'][] = $apiData;
    
            // Hit the external API
            $apiResponse = $this->callExternalApi($apiData);
            
            // You might want to log the API response or handle errors
            \Log::info('API Response for saving ID '.$saving->id, ['response' => $apiResponse]);

            
            
            return response()->json(['message' => 'Daily profits calculated and saved successfully.', 'data' => $dailyReturnData]);

        }
    
    }

            protected function callExternalApi($data)
        {
            $url = 'https://api.efulife.com/epay/digi/tkf/sync/profit';
            $headers = [
                'Authorization: Bearer XXXXAAA123EPDIGITAKAFUL',
                'channelcode: EPDIGITAKAFUL',
                'Content-Type: application/json',
            ];

            // Prepare the request payload
            $payload = [
                'status' => 200,
                'message' => 'Daily returns retrieved successfully.',
                'data' => [$data] // Wrap the data in an array as per the example
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if (curl_errno($ch)) {
                $error = curl_error($ch);
                curl_close($ch);
                throw new \Exception("cURL error: $error");
            }
            
            curl_close($ch);

            return [
                'http_code' => $httpCode,
                'response' => json_decode($response, true)
            ];
        }


    // Helper: AES Encryption
    private function aesEncrypt($plaintext)
    {
        $key = 'your-16-byte-aes-key'; // Replace with your AES key (must be 16/24/32 bytes)
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));
        $ciphertext = openssl_encrypt($plaintext, 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $ciphertext);
    }

    // Helper: Generate Encrypt Header
    private function generateEncryptHeader()
    {
        $symmetricKey = 'your-16-byte-aes-key'; // Same as AES key
        $publicKey = openssl_pkey_get_public($this->publicKey);

        if (!$publicKey) {
            Log::error("Invalid public key for encrypt header.");
            return '';
        }

        openssl_public_encrypt($symmetricKey, $encryptedSymmetricKey, $publicKey, OPENSSL_PKCS1_PADDING);
        openssl_free_key($publicKey);

        //return "jahangir";
        return "algorithm=RSA_AES,keyVersion=1,symmetricKey=" . urlencode(base64_encode($encryptedSymmetricKey));
    }

    // Helper: Signature Generation
    private function generateSignatureCashDeposit($data)
    {
        $privateKey = openssl_pkey_get_private($this->privateKey);

        if (!$privateKey) {
            Log::error("Error loading private key.");
            return '';
        }

        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        openssl_free_key($privateKey);

        return urlencode(base64_encode($signature));
    }



}