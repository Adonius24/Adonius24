<?php
namespace App\Services\Notification;

class WhatsappNotifier
{
    public function __construct(private string $endpoint, private string $token)
    {
    }

    public function send(string $phoneNumber, string $message, array $context = []): array
    {
        $payload = [
            'to' => $phoneNumber,
            'message' => $message,
            'context' => $context,
            'endpoint' => $this->endpoint,
        ];
        NotificationService::log('whatsapp', $payload);
        return [
            'success' => true,
            'payload' => $payload,
            'note' => 'Simulated send. Wire this service to WhatsApp Cloud API or Twilio in production.'
        ];
    }
}
