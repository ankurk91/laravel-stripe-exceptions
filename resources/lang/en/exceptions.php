<?php

return [
    'payment' => [
        'unknown' => 'Something went wrong during payment.',
        'invalid_card' => 'Invalid card.',
        'rate_limit' => 'Too many requests. Please try again later.',
        'invalid_request' => 'Invalid payment request.',
        'authentication' => 'Error authenticating with payment gateway.',
        'connection' => 'Error communicating payment gateway.',
        'general' => 'Unable to proceed with payment at this moment.',
    ],

    'oauth' => [
        'unknown' => 'Something went wrong during authorization.',
        'invalid_client' => 'Unable to authorize with Stripe.',
        'invalid_request' => 'Invalid request.',
        'general' => 'Unable to authorize with Stripe.',
    ],
];
