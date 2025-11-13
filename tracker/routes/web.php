<?php
use App\Http\Controllers\TrackingController;

$controller = new TrackingController();
$router->get('/', fn () => $controller->index());
$router->get('/api/track', fn () => $controller->track());
