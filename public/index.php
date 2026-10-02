<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Contracts\NotificationChannelInterface;
use App\Services\NotificationService;
use App\Services\SmsChannel;
use App\Services\WhatsAppChannel;
use App\Services\NotificationDispatcher;

class FailingWhatsAppMock implements NotificationChannelInterface {
    public function send(string $recipient, string $message): bool {
        throw new Exception("Twilio API unreachable (HTTP 503 Service Unavailable)");
    }
}

$service = new NotificationService();
echo $service->ping().PHP_EOL;

$sms = new SmsChannel("SOLAR_RW");
$whatsapp = new WhatsAppChannel("AC_TEST_12345", "AUTH_TOKEN_XYZ", "+250788000000");
$brokenWhatsApp = new FailingWhatsAppMock();

$dispatcher = new NotificationDispatcher($brokenWhatsApp, $sms);

$sms->send("+250788000000", "Your power token is: 1234-5678-9012");
$whatsapp->send("+250788000001", "Token: 3456-7890-1234");

echo "--- BEGIN DISPATCH TEST ---" . PHP_EOL;
$dispatcher->dispatch("+250788000002", "Your power token is: 5678-9012-3456");
echo "--- END DISPATCH TEST ---" . PHP_EOL;