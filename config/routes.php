<?php

use App\Http\Controllers\LambdaController;

return [
    'overrides' => [
        // `accounts` service
        'accounts' => [
            // rule for forwarding `http://laravel-gateway.test/accounts/accounts` to `http://accounts.test/`
            'accounts' => '/',
        ],
        // `functions` aka AWS lambdas
        'functions' => [
            // rule for handling a basic lambda
            'lambda' => function($request) {
                $controller = new LambdaController;
                return $controller->lambda($request);
            },
        ],
    ],
];
