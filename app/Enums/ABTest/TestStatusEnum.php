<?php

namespace App\Enums\ABTest;

enum TestStatusEnum: string
{
    case CREATED = 'created';

    case RUNNING = 'running';

    case STOPPED = 'stopped';
}
