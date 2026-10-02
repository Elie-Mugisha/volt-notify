<?php
namespace App\Services;
use App\Contracts\NotificationChannelInterface;

class SmsChannel implements NotificationChannelInterface {
    public function __construct(
        private string $senderId = "Solar_RW"
    ){}

    public function send(string $recipient, string $message): bool {
        echo "[SMS - {$this->senderId}] Dispatching to {$recipient}: '{$message}'" . PHP_EOL;
        return true;
    }

    
}


