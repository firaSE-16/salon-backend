<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    // Let our manual CORS shim in public/index.php set Access-Control-Allow-Origin.
    // Keep this empty to avoid duplicate values like "origin, *".
    'allowed_origins' => [
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
        'X-Salon-Id',
        'Accept',
        'Origin',
    ],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];