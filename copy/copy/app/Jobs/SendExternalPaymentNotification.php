<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendExternalPaymentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function handle()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer XXXXAAA123EPDIGITAKAFUL',
            'channelcode' => 'EPDIGITAKAFUL',
            'Content-Type' => 'application/json',
        ])->post('https://api.efulife.com/epay/digi/tkf/sync/payments', $this->payload);

        Log::info('API Response:', [
            'status' => $response->status(),
            'body' => $response->body(),
            'headers' => $response->headers(),
        ]);
    }
}
