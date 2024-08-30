<?php

namespace App\Contracts\ABTest;

use App\Models\ABTest\Test;
use App\Models\Session;

interface TestServiceContract
{
    /**
     * @param string $test
     * @return bool
     */
    public function hasTestForSession(string $test): bool;

    /**
     * @return array
     */
    public function getTestsFromSession(): array;

    /**
     * @param string $test
     * @return string
     */
    public function getVariantFromSession(string $test): null | string;

    /**
     * @param Test $test
     * @param Session $session
     * @return bool
     */
    public function loadTestForSession(Test $test, Session $session): bool;

    /**
     * @param Session $session
     * @return void
     */
    public function loadTestsForSession(Session $session): void;

    /**
     * @param Session $session
     * @return array
     */
    public function removeStoppedTestsFromSession(Session $session): array;
}
