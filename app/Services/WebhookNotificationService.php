<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookNotificationService
{
    protected $webhookUrl;

    public function __construct()
    {
        $this->webhookUrl = Config::get('services.webhook.url');

        if (is_null($this->webhookUrl)) {
            throw new \Exception('Webhook URL is not set.');
        }
    }

    public function sendOrderStatusUpdate($orderId, $newStatus)
    {
        $payload = [
            'order_id' => $orderId,
            'status' => $newStatus,
        ];

        $response = Http::asForm()->post($this->webhookUrl, $payload);

        return $response->successful();
    }
}
