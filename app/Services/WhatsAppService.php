<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message via UltraMsg API.
     *
     * Set in .env:
     *   ULTRAMSG_INSTANCE=your_instance_id
     *   ULTRAMSG_TOKEN=your_token
     *
     * @param  string  $phone  Phone number (10 digits or with country code)
     * @param  string  $message
     * @return bool
     */
    public static function send(string $phone, string $message): bool
    {
        $instance = config('services.ultramsg.instance');
        $token    = config('services.ultramsg.token');

        if (empty($instance) || empty($token)) {
            Log::warning('WhatsApp not configured: ULTRAMSG_INSTANCE or ULTRAMSG_TOKEN missing.');
            return false;
        }

        // Normalize phone: strip non-digits, ensure country code prefix
        $phone = preg_replace('/\D/', '', $phone);
        if (strlen($phone) === 10) {
            $phone = '91' . $phone; // Default India country code
        }

        try {
            $response = Http::asForm()->post(
                "https://api.ultramsg.com/{$instance}/messages/chat",
                [
                    'token'    => $token,
                    'to'       => $phone,
                    'body'     => $message,
                    'priority' => 10,
                ]
            );

            if ($response->successful()) {
                Log::info("WhatsApp message sent to {$phone}");
                return true;
            } else {
                Log::error("WhatsApp send failed: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp exception: " . $e->getMessage());
            return false;
        }
    }
}
