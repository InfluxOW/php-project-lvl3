<?php

return [
    'domain' => [
        'class' => App\Domain::class,
        'property_path' => 'state',
        'states' => [
            'waiting',
            'processing',
            'failed',
            'successed'
        ],
        'transitions' => [
            'process' => [
                'from' => ['waiting'],
                'to' => 'processing'
            ],
            'fail' => [
                'from' => ['processing'],
                'to' => 'failed'
            ],
            'success' => [
                'from' => ['processing'],
                'to' => 'successed'
            ]
        ]
    ]
];
