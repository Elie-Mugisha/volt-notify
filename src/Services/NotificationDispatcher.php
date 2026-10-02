<?php
namespace App\Services;
use App\Contracts\NotificationChannelInterface;
use Exception;

class NotificationDispatcher {
    public function __construct(
        private NotificationChannelInterface $primaryChannel,
        private ?NotificationChannelInterface $fallbackChannel = null
    ) {}

    /**
     * Dispatch notification with automatic fallback handling
     */

    public function dispatch(string $recipient, string $message): bool {
        try{
            echo "[Dispatcher] Attempting primary channel dispatch..." . PHP_EOL;
            $success = $this->primaryChannel->send($recipient, $message);

            if($success){
                echo "[Dispatcher] Notification delivered via primary channel." . PHP_EOL;
                return true;
            }

            throw new Exception("Primary channel returned failure status");
        } catch (Exception $e){
            echo "[Dispatcher - ALERT] Primary channel failed: {$e->getMessage()}" . PHP_EOL;

            if($this->fallbackChannel !== null){
                echo "[Dispatcher] Engaging fallback channel immediately..." . PHP_EOL;
                return $this->fallbackChannel->send($recipient, $message);
            }

            return false;
        }
    }
}