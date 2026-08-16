<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Log;

class LogWhatsAppService implements WhatsAppServiceInterface
{
    /**
     * Send a WhatsApp message (Logs it to laravel.log instead of actually sending).
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function sendMessage(string $phone, string $message): bool
    {
        Log::info("================ WHATSAPP MESSAGE SENT ================");
        Log::info("To: " . $phone);
        Log::info("Message:\n" . $message);
        Log::info("======================================================");

        return true;
    }
}
