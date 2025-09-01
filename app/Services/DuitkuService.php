<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DuitkuService
{
    private $merchantCode;
    private $apiKey;
    private $baseUrl;
    private $callbackUrl;
    private $returnUrl;

    public function __construct()
    {
        $this->merchantCode = config('services.duitku.merchant_code');
        $this->apiKey = config('services.duitku.api_key');
        $this->baseUrl = config('services.duitku.sandbox') 
            ? 'https://api-sandbox.duitku.com/api/merchant'
            : 'https://api-prod.duitku.com/api/merchant';
        $this->callbackUrl = config('services.duitku.callback_url');
        $this->returnUrl = config('services.duitku.return_url');
    }

    /**
     * Generate signature for Duitku API
     */
    private function generateSignature($timestamp)
    {
        $data = $this->merchantCode . '-' . $timestamp . '-' . $this->apiKey;
        return hash('sha256', $data);
    }

    /**
     * Get current timestamp in Jakarta timezone (milliseconds)
     */
    private function getTimestamp()
    {
        return round(microtime(true) * 1000);
    }

    /**
     * Create invoice with Duitku
     */
    public function createInvoice($data)
    {
        $timestamp = $this->getTimestamp();
        $signature = $this->generateSignature($timestamp);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'x-duitku-signature' => $signature,
            'x-duitku-timestamp' => $timestamp,
            'x-duitku-merchantcode' => $this->merchantCode,
        ];

        $payload = [
            'paymentAmount' => $data['amount'],
            'merchantOrderId' => $data['order_id'],
            'productDetails' => $data['product_details'],
            'additionalParam' => $data['additional_param'] ?? '',
            'merchantUserInfo' => $data['merchant_user_info'] ?? '',
            'customerVaName' => $data['customer_name'],
            'email' => $data['email'],
            'phoneNumber' => $data['phone'],
            'itemDetails' => $data['items'],
            'customerDetail' => [
                'firstName' => $data['first_name'],
                'lastName' => $data['last_name'],
                'email' => $data['email'],
                'phoneNumber' => $data['phone'],
                'billingAddress' => [
                    'firstName' => $data['first_name'],
                    'lastName' => $data['last_name'],
                    'address' => $data['address'] ?? '',
                    'city' => $data['city'] ?? '',
                    'postalCode' => $data['postal_code'] ?? '',
                    'phone' => $data['phone'],
                    'countryCode' => 'ID'
                ],
                'shippingAddress' => [
                    'firstName' => $data['first_name'],
                    'lastName' => $data['last_name'],
                    'address' => $data['address'] ?? '',
                    'city' => $data['city'] ?? '',
                    'postalCode' => $data['postal_code'] ?? '',
                    'phone' => $data['phone'],
                    'countryCode' => 'ID'
                ]
            ],
            'callbackUrl' => $this->callbackUrl,
            'returnUrl' => $this->returnUrl,
            'expiryPeriod' => 60 // 60 minutes
        ];

        try {
            $response = Http::withHeaders($headers)
                ->post($this->baseUrl . '/createInvoice', $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            } else {
                Log::error('Duitku API Error', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Failed to create invoice',
                    'error' => $response->json()
                ];
            }
        } catch (\Exception $e) {
            Log::error('Duitku Service Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Service error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify callback signature
     */
    public function verifyCallback($data)
    {
        $signature = $data['signature'] ?? '';
        $merchantOrderId = $data['merchantOrderId'] ?? '';
        $amount = $data['amount'] ?? '';
        $merchantCode = $data['merchantCode'] ?? '';
        
        $calculatedSignature = hash('sha256', $merchantCode . $amount . $merchantOrderId . $this->apiKey);
        
        return hash_equals($calculatedSignature, $signature);
    }
}