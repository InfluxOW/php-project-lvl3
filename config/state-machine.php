<?php

use App\Domain;
use App\Enums\DomainState;
use App\Enums\DomainTransition;

return [
    Domain::class => [
        'class' => Domain::class,
        'property_path' => 'state',
        'states' => [
            DomainState::WAITING,
            DomainState::PROCESSING,
            DomainState::FAILED,
            DomainState::SUCCEEDED,
        ],
        'transitions' => [
            DomainTransition::PROCESS => [
                'from' => [DomainState::WAITING],
                'to' => DomainState::PROCESSING
            ],
            DomainTransition::FAIL => [
                'from' => [DomainState::PROCESSING],
                'to' => DomainState::FAILED
            ],
            DomainTransition::SUCCESS => [
                'from' => [DomainState::PROCESSING],
                'to' => DomainState::SUCCEEDED
            ]
        ]
    ]
];
