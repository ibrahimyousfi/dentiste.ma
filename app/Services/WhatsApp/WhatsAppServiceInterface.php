<?php

namespace App\Services\WhatsApp;

interface WhatsAppServiceInterface
{
    /**
     * Send a WhatsApp message to a specific phone number.
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function sendMessage(string $phone, string $message): bool;
}
