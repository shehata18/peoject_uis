<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendOrderStatusUpdatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusUpdated $event): void
    {
        // The URL of the webhook
        $webhookUrl = 'https://webhook.site/3e07ad06-96a0-4544-ace5-3b00d35ba073';

        // The data to send to the webhook
        $data = [
            'orderId' => $event->orderId,
            'newStatus' => $event->newStatus,
        ];

        // Send the POST request
        Http::post($webhookUrl, $data);
    }
}
