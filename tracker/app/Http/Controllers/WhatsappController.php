<?php
namespace App\Http\Controllers;

use App\Services\Notification\WhatsappNotifier;

class WhatsappController
{
    public function send()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $phone = $input['phone'] ?? null;
        $message = $input['message'] ?? null;
        $tracking = $input['tracking_number'] ?? null;

        if (!$phone || !$message) {
            http_response_code(422);
            echo json_encode(['error' => 'Phone and message are required']);
            return;
        }

        $notifier = new WhatsappNotifier('https://graph.facebook.com/v17.0/messages', 'YOUR_TOKEN');
        $result = $notifier->send($phone, $message, [
            'tracking_number' => $tracking,
        ]);
        echo json_encode($result);
    }
}
