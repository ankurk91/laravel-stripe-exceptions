<?php

return [
    'api' => [
        'unknown' => 'Something went wrong.',
        'invalid_card' => 'Invalid card.',
        'rate_limit' => 'Too many requests. Please try again later.',
        'invalid_request' => 'Invalid request.',
        'authentication' => 'Error authenticating with payment gateway.',
        'connection' => 'Error communicating with payment gateway.',
        'general' => 'Unable to proceed with request at this moment.',
    ],

    'oauth' => [
        'unknown' => 'Something went wrong during authorization.',
        'invalid_client' => 'Unable to authorize with Stripe.',
        'invalid_request' => 'Invalid request.',
        'general' => 'Unable to authorize with Stripe.',
    ],
];
