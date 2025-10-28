<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiKey;
    protected $baseUrl;
    protected $sender;

    public function __construct()
    {
        $this->apiKey = config('services.ngumzo.api_key');
        $this->baseUrl = config('services.ngumzo.base_url', 'https://ngumzo.com/v1');
        $this->sender = config('services.ngumzo.sender_phone');
    }

    /**
     * Send a text message to a WhatsApp number
     *
     * @param string $recipient
     * @param string $message
     * @return array
     */
    public function sendTextMessage(string $recipient, string $message): array
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => $this->apiKey,
            ])->post($this->baseUrl . '/send-message', [
                'sender' => $this->sender,
                'recipient' => $recipient,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'recipient' => $recipient,
                    'response' => $response->json(),
                ]);

                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            Log::error('Failed to send WhatsApp message', [
                'recipient' => $recipient,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return [
                'success' => false,
                'error' => $response->body(),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Exception while sending WhatsApp message', [
                'recipient' => $recipient,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send a media message to a WhatsApp number
     *
     * @param string $recipient
     * @param string $message
     * @param string $mediaType (image, document, video, audio)
     * @param string $mediaUrl
     * @param string|null $caption
     * @return array
     */
    public function sendMediaMessage(
        string $recipient,
        string $message,
        string $mediaType,
        string $mediaUrl,
        ?string $caption = null
    ): array {
        try {
            $payload = [
                'sender' => $this->sender,
                'recipient' => $recipient,
                'message' => $message,
                'media_type' => $mediaType,
                'url' => $mediaUrl,
            ];

            if ($caption) {
                $payload['caption'] = $caption;
            }

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => $this->apiKey,
            ])->post($this->baseUrl . '/send-message', $payload);

            if ($response->successful()) {
                Log::info('WhatsApp media message sent successfully', [
                    'recipient' => $recipient,
                    'media_type' => $mediaType,
                    'response' => $response->json(),
                ]);

                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            Log::error('Failed to send WhatsApp media message', [
                'recipient' => $recipient,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return [
                'success' => false,
                'error' => $response->body(),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Exception while sending WhatsApp media message', [
                'recipient' => $recipient,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check if a number is registered on WhatsApp
     *
     * @param string $number
     * @return array
     */
    public function checkNumber(string $number): array
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => $this->apiKey,
            ])->post($this->baseUrl . '/check-number', [
                'sender' => $this->sender,
                'number' => $number,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => $response->body(),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check account balance
     *
     * @return array
     */
    public function checkBalance(): array
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => $this->apiKey,
            ])->post($this->baseUrl . '/check-balance', [
                'sender' => $this->sender,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => $response->body(),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
