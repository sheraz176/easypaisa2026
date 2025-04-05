<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DateTime;
use DateTimeZone;
use App\Models\EasypaisaUser;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;

class EasypaisaController extends Controller
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
        $privateKey = openssl_pkey_get_private($this->privateKey);
        if (!$privateKey) {
            Log::error("Error loading private key.");
            return response()->json(['error' => 'Invalid private key'], 500);
        }

        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        openssl_free_key($privateKey);

        return urlencode(base64_encode($signature));
    }

    private function sendRequest($endpoint, $headers, $data)
    {
        $url = $this->baseUrl . $endpoint;

        $response = Http::withHeaders([
            "Request-Time"  => $headers['Request-Time'],
            "Client-Id"     => $headers['Client-Id'],
            "Signature"     => $headers['Signature'],
            "Content-Type"  => "application/json"
        ])->post($url, $data);

        return $response->json();
    }


    public function applyToken()
    {
            $date = new DateTime('now', new DateTimeZone('Asia/Karachi')); // Set to Pakistan Time (UTC+5)
            $requestTime = $date->format("Y-m-d\TH:i:s.vP");

            $params = [
                'Request-Time' => $requestTime,
                'Client-Id' => $this->clientId
            ];

            $data = [
                'grantType' => 'PASSWORD',
                'apiKey' => $this->apiKey
            ];

            $signatureString = "POST /v1/authentications/applyToken\n" .
                "{$params['Client-Id']}.{$params['Request-Time']}.." . json_encode($data);

            $signature = $this->generateSignature($signatureString);
            $params['Signature'] = "algorithm=RSA2048, keyVersion=1, signature=$signature";
            $response = $this->sendRequest('/v1/authentications/applyToken', $params, $data);
            return response()->json($response);
        }



        public function checkOpenId(Request $request)
        {
            try {
                // Validate the request
                $validated = $request->validate([
                    'open_id' => 'required|string',
                ]);

                $openId = $validated['open_id'];
                $user = EasypaisaUser::where('open_id', $openId)->first();


                if ($user) {
                    return response()->json([
                        'status' => 409, // Conflict
                        'message' => 'OpenId already exists.',
                        'exists' => true,
                        'data' => $user, // Convert model to array
                    ], 409);
                } else {
                    return response()->json([
                        'status' => 404, // Not Found
                        'message' => 'OpenId does not exist.',
                        'exists' => false
                    ], 404);
                }
            } catch (ValidationException $e) {
                return response()->json([
                    'status' => 422, // Unprocessable Entity
                    'message' => 'Validation error.',
                    'errors' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500, // Internal Server Error
                    'message' => 'Something went wrong. Please try again.',
                ], 500);
            }
        }



    private function sendRequesAuthCode($endpoint, $headers, $data)
    {
            $url = $this->baseUrl . $endpoint;

            // dd([
            //     'url' => $url,
            //     'headers' => [
            //         "Content-Type"  => "application/json",
            //         "Client-Id"     => $headers['Client-Id'],
            //         "Request-Time"  => $headers['Request-Time'],
            //         "Access-Token"  => $headers['Access-Token'],
            //         "Signature"     => $headers['Signature'],

            //     ],
            //     'data' => $data
            // ]);
            $response = Http::withHeaders([
                "Content-Type"  => "application/json",
                "Client-Id"     => $headers['Client-Id'],
                "Request-Time"  => $headers['Request-Time'],
                "Access-Token"     => $headers['Access-Token'],
                "Signature"     => $headers['Signature']
            ])->post($url, $data);

            return $response->json();
            }


    public function getAuthCode(Request $request)
    {

            $date = new DateTime('now', new DateTimeZone('Asia/Karachi')); // Set to Pakistan Time (UTC+5)
            $requestTime = $date->format("Y-m-d\TH:i:s.vP");

            // Validate request
            $request->validate([
                'authCode' => 'required|string',
            ]);

            $authCode = $request->input('authCode');

            // Headers
            $params = [
                'Request-Time' => $requestTime,
                'Client-Id'    => $this->clientId,
                'Access-Token' => $this->accessToken
            ];


            // Request Body
            $data = [
                'authCode' => $authCode
            ];



            // $signatureString = "POST /v1/users/inquireUserInfo\n" .
            // "{$params['Client-Id']}.{$params['Request-Time']}..{$accessToken}." . json_encode($data);

             $signatureString = "POST /v1/users/inquireUserInfo\n" .
            "{$params['Client-Id']}.{$params['Request-Time']}.{$this->accessToken}." . json_encode($data);

            // dd($signatureString);

            // Generate Signature
            $signature = $this->generateSignature($signatureString);
            $params['Signature'] = "algorithm=RSA2048, keyVersion=1, signature=$signature";

            try {
                $response = $this->sendRequesAuthCode('/v1/users/inquireUserInfo', $params, $data);

                if (isset($response['userInfo']) && isset($response['result'])) {
                    EasypaisaUser::updateOrCreate(
                        ['open_id' => $response['userInfo']['openId']], // Unique identifier
                        [
                            'union_id' => $response['userInfo']['unionId'],
                            'user_msisdn' => $response['userInfo']['userMsisdn'],
                            'result_code' => $response['result']['resultCode'],
                            'result_status' => $response['result']['resultStatus'],
                            'result_message' => $response['result']['resultMessage'],
                        ]
                    );

                    // Custom success response
                    return response()->json([
                        'status' => 200,
                        'message' => 'UserInfo Successfully Saved',
                        'data' => $response
                    ], 200);
                }

                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid response received',
                    'data' => $response
                ], 400);

            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['error' => $e->getMessage()], 422);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
            }

    }
      // Step 2: Handle AuthCode from Frontend




// Example: Generate Access Token (Modify as needed)
private function getAccessToken()
{
    return '9d5a1bf90ce07045799d4b27341022b72e5b8735'; // Yahan actual token retrieval logic add karein
}



}
