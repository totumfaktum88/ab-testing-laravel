<?php

namespace App\Enums\Session;

enum EventTypeEnum: string
{
    case PAGEVIEW = 'pageview';
    case TEST_INITIALIZED = 'test_initialized';
    case TEST_REMOVED = 'test_removed';
}
