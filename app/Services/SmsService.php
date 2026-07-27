<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send Mobile SMS Notification to Patient's Phone.
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public static function sendSms(string $phone, string $message): bool
    {
        $cleanPhone = preg_replace('/\D/', '', $phone);
        if (empty($cleanPhone)) {
            Log::warning("Mobile SMS Failed: Empty phone number provided.");
            return false;
        }

        Log::info("📱 [MOBILE SMS NOTIFICATION] Sent to {$cleanPhone}: {$message}");

        // 1. Check for Fast2SMS API Key
        $apiKey = env('FAST2SMS_API_KEY');
        if (!empty($apiKey)) {
            try {
                $response = Http::withHeaders([
                    'authorization' => $apiKey,
                    'Content-Type'  => 'application/json',
                ])->post('https://www.fast2sms.com/dev/bulkV2', [
                    'route'    => 'q',
                    'message'  => $message,
                    'language' => 'english',
                    'flash'    => 0,
                    'numbers'  => $cleanPhone,
                ]);

                if ($response->successful()) {
                    Log::info("Fast2SMS notification delivered to {$cleanPhone}");
                } else {
                    Log::error("Fast2SMS API failed: " . $response->body());
                }
            } catch (\Exception $e) {
                Log::error("Fast2SMS exception: " . $e->getMessage());
            }
        }

        // 2. Also send via WhatsApp Service for dual-channel reliability
        try {
            WhatsAppService::send($cleanPhone, $message);
        } catch (\Exception $e) {
            Log::error("WhatsApp alert exception: " . $e->getMessage());
        }

        return true;
    }
}
