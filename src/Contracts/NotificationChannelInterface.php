<?php
namespace App\Contracts;

interface NotificationChannelInterface {
    /**
     * Send a notification to a recipient
     * 
     * @param string $recipient Target phone number (e.g. "+250788000000")
     * @param string $message The body/token payload
     * @return bool True if sent successfully, false otherwise
     */
    public function send(string $recipient, string $message): bool;
}