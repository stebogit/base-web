<?php
// show ALL, really ALL, errors in development
if (getenv('ENV') !== 'production') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
}

return [
    'settings' => [
        'displayErrorDetails' => (bool)getenv('DISPLAY_ERRORS'),
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // PDO
        "db" => [
            "dbname" => getenv('DB_NAME'),
            "dbhost" => getenv('DB_HOST'),
            "dbuser" => getenv('DB_USER'),
            "dbpass" => getenv('DB_PASS'),
            "dbport" => getenv('DB_PORT'),
        ],

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => (int)getenv('LOG_LEVEL') ?: Monolog\Logger::ERROR
        ],
    ],
];
