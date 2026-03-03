<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:5173',
        'http://localhost:3000',
        'https://salon-front-9map9pn9z-loariftech-4320s-projects.vercel.app',
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