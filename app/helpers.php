<?php

use App\Domain;
use App\Enums\DomainState;

function getDomainTableStyle(Domain $domain, string $route): void
{
    switch ($route) {
        case 'index':
            $class = 'd-flex table-';
            break;
        case 'show':
            $class = 'd-flex align-items-center table-borderless table-';
            break;
    }

    switch ($domain->stateMachine()->getState()) {
        case DomainState::FAILED:
            $status = 'danger';
            break;
        case DomainState::PROCESSING:
            $status = 'warning';
            break;
        case DomainState::WAITING:
            $status = 'info';
            break;
        case DomainState::SUCCEEDED:
            $status = 'success';
            break;
    }

    echo (isset($class, $status)) ? "{$class}{$status}" : '';
}
