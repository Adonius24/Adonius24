<?php
use App\Http\Controllers\WhatsappController;

$controller = new WhatsappController();
$router->post('/api/whatsapp/send', fn () => $controller->send());
