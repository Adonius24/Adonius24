<?php
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/app/';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Services\Notification\NotificationService;

if (!is_dir(__DIR__ . '/storage/logs')) {
    mkdir(__DIR__ . '/storage/logs', 0777, true);
}
if (!is_dir(__DIR__ . '/storage/cache')) {
    mkdir(__DIR__ . '/storage/cache', 0777, true);
}

NotificationService::bootstrap();
