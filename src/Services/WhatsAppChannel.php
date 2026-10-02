<?php
namespace App\Services;
use App\Contracts\NotificationChannelInterface;

class WhatsAppChannel implements NotificationChannelInterface {
    public function __construct(
        private string $accountSid,
        private string $authToken,
        private string $fromNumber,
    ) {}

    public function send(string $recipient, string $message): bool {
        echo "[WhatsApp] Dispatching via {$this->fromNumber} (SID: {$this->accountSid}) to {$recipient}: '{$message}'". PHP_EOL;
        return true;
    }
}