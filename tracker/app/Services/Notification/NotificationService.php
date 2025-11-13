<?php
namespace App\Services\Notification;

class NotificationService
{
    private static string $logFile = __DIR__ . '/../../../storage/logs/notifications.log';

    public static function bootstrap(): void
    {
        if (!file_exists(self::$logFile)) {
            file_put_contents(self::$logFile, '');
        }
    }

    public static function log(string $channel, array $payload): void
    {
        $entry = date('c') . " [{$channel}] " . json_encode($payload) . PHP_EOL;
        file_put_contents(self::$logFile, $entry, FILE_APPEND);
    }
}
