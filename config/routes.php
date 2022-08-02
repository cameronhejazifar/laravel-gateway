<?php

return [
    'overrides' => [
        // `accounts` service
        'accounts' => [
            // rule for forwarding `http://laravel-gateway.test/accounts/accounts` to `http://accounts.test/`
            'accounts' => '/',
        ],
    ],
];
