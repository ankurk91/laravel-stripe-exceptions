<?php

return [
    'payment' => [
        'unknown' => 'Something went wrong.',
        'invalid_card' => 'Invalid card.',
        'rate_limit' => 'Too many requests. Please try again later.',
        'bad_request' => 'Invalid payment request.',
        'authentication' => 'Error authenticating with payment gateway.',
        'connection' => 'Error communicating payment gateway.',
        'general' => 'Unable to proceed with payment at this moment.',
    ],

    'oauth' => [
        'failed' => 'Unable to authorize with Stripe.',
    ],
];
