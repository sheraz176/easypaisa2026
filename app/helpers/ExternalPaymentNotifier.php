<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ExternalPaymentNotifier
{
    /**
     * Send a payment notification to external API and log the response.
     *
     * @param array $requestData
     * @param string $transactionId
     * @return void
     */
    public static function logPaymentNotification(array $requestData, string $transactionId): void
    {
        Log::info('Starting LogPaymentFunction');

        // Store request data (payload) into the database
        $payload = json_encode($requestData);
        if ($payload === false) {
            Log::error('Failed to encode request data to JSON', [
                'transaction_id' => $transactionId,
                'error' => json_last_error_msg()
            ]);
            return;
        }

        // Initialize Guzzle client
        $client = new Client([
            'timeout' => 30, // Set a reasonable timeout
        ]);

        // Set headers
        $headers = [
            'Authorization' => 'Bearer XXXXAAA123EPDIGITAKAFUL',
            'channelcode' => 'EPDIGITAKAFUL',
            'Content-Type' => 'application/json',
        ];

        try {
            // Sending synchronous request
            Log::info('Sending payment notification request to API');
            $response = $client->post('https://api.efulife.com/epay/digi/tkf/sync/payments', [
                'json' => $requestData,
                'headers' => $headers,
            ]);

            // Process response
            $responseBody = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();

            Log::info('Payment Notification Response', [
                'status_code' => $statusCode,
                'transaction_id' => $transactionId,
                'response_body' => $responseBody,
            ]);

            // Insert into DB with response status
            DB::table('external_api_logs')->insert([
                'payload' => $payload,
                'status' => $statusCode >= 200 && $statusCode < 300 ? 'success' : 'failed', // Success if status is in 2xx range
                'response' => $responseBody,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('Successfully logged payment notification response into DB');

        } catch (RequestException $e) {
            // Handle request exception (API failure)
            $errorMessage = $e->getMessage();
            $response = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null;

            Log::error('Payment Notification Failed', [
                'error_message' => $errorMessage,
                'transaction_id' => $transactionId,
                'response' => $response,
            ]);

            // Insert failure log into DB
            DB::table('external_api_logs')->insert([
                'payload' => $payload,
                'status' => 'failed', // Failed status for any error
                'response' => $response ?? $errorMessage,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Log::info('Successfully logged payment notification failure into DB');
        } catch (\Exception $e) {
            // General exception (Unexpected errors)
            Log::error('Error in External Payment Notification', [
                'error_message' => $e->getMessage(),
                'transaction_id' => $transactionId,
                'stack_trace' => $e->getTraceAsString(),
            ]);

            // Insert general exception log into DB
            DB::table('external_api_logs')->insert([
                'payload' => $payload,
                'status' => 'failed', // Failed status for any unexpected exception
                'response' => $e->getMessage(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Log::info('Successfully logged general exception into DB');
        }
    }
}
