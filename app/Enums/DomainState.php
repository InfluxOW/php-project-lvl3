<?php

namespace App\Enums;

class DomainState
{
    public const WAITING = 'waiting';
    public const PROCESSING = 'processing';
    public const FAILED = 'failed';
    public const SUCCEEDED = 'succeeded';
}
