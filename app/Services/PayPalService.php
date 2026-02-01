<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    protected PayPalClient $client;

    public function __construct()
    {
        $this->client = new PayPalClient;
        $this->client->setApiCredentials(config('paypal'));
        $this->client->getAccessToken();
    }

    /**
     * Create a PayPal order
     */
    public function createOrder(float $amount, string $description): array
    {
        $order = $this->client->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'brand_name' => config('app.name'),
                'locale' => 'en-US',
                'landing_page' => 'BILLING',
                'user_action' => 'PAY_NOW',
            ],
            'purchase_units' => [
                [
                    'description' => $description,
                    'amount' => [
                        'currency_code' => 'EUR',
                        'value' => number_format($amount, 2, '.', ''),
                    ],
                ],
            ],
        ]);

        return $order;
    }

    /**
     * Capture a PayPal order after approval
     */
    public function captureOrder(string $orderId): array
    {
        return $this->client->capturePaymentOrder($orderId);
    }

    /**
     * Get order details
     */
    public function getOrderDetails(string $orderId): array
    {
        return $this->client->showOrderDetails($orderId);
    }
}
