<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class LogPaymentNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $requestData;
    protected string $transactionId;


    public function __construct(array $requestData, ?string $transactionId = null)
    {
        $this->requestData = $requestData;
        // dd($requestData);
        $this->transactionId = $transactionId;
         ///($transactionId);
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

       //d('hi');

//         Log::channel('data_api')->info('Starting LogPaymentNotificationJob', [
//             'message' => "Starting LogPaymentNotificationJob.",
//              ]);

        $payload = json_encode($this->requestData);
              
      //dd($payload);

        if ($payload === false) {
            Log::error('Failed to encode request data to JSON', [
                'transaction_id' => $this->transactionId,
                'error' => json_last_error_msg()
            ]);
            return;
        }

        $client = new Client([
            'timeout' => 30,
        ]);

        $headers = [
            'Authorization' => 'Bearer XXXXAAA123EPDIGITAKAFUL',
            'channelcode' => 'EPDIGITAKAFUL',
            'Content-Type' => 'application/json',
        ];

        try {

            Log::channel('data_api')->info('Sending payment notification request to external API.', [
                'message' => "Sending payment notification request to external API.",
               ]);

            $response = $client->post('https://api.efulife.com/epay/digi/tkf/sync/payments', [
                'json' => $this->requestData,
                'headers' => $headers,
            ]);

            $responseBody = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();


            Log::channel('data_api')->info('payment Notification Response Received.', [
                'status_code' => $statusCode,
                'transaction_id' => $this->transactionId,
                'response_body' => $responseBody,
            ]);

            DB::table('external_api_logs')->insert([
                'payload' => $payload,
                'status' => $statusCode >= 200 && $statusCode < 300 ? 'success' : 'failed',
                'response' => $responseBody,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            Log::channel('data_api')->info('Successfully logged payment notification response into DB.', [
                'message' => "Successfully logged payment notification response into DB.",
               ]);

        } catch (RequestException $e) {
            $errorMessage = $e->getMessage();
            $response = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null;

         

            Log::channel('data_api')->info('Payment Notification Failed.', [
                'error_message' => $errorMessage,
                'transaction_id' => $this->transactionId,
                'response' => $response,]);

            DB::table('external_api_logs')->insert([
                'payload' => $payload,
                'status' => 'failed',
                'response' => $response ?? $errorMessage,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            Log::channel('data_api')->info('Logged failed payment notification to DB.', [
                'message' => "Logged failed payment notification to DB.",
               ]);

        } catch (\Exception $e) {
            Log::error(' Unexpected error in Payment Notification Job', [
                'error_message' => $e->getMessage(),
                'transaction_id' => $this->transactionId,
                'stack_trace' => $e->getTraceAsString(),
            ]);

            DB::table('external_api_logs')->insert([
                'payload' => $payload,
                'status' => 'failed',
                'response' => $e->getMessage(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

          
            Log::channel('data_api')->info('Logged general exception to DB.', [
                'message' => "Logged general exception to DB",
               ]);

        }
    }
}
