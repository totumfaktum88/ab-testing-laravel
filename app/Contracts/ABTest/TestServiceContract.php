<?php

namespace App\Contracts\ABTest;

use App\Contracts\ABTest\Model\TestContract;
use App\Contracts\ABTest\Model\VariantContract;
use App\Enums\ABTest\TestStatusEnum;
use App\Models\ABTest\Test;
use App\Models\Session;

interface TestServiceContract
{
    /**
     * @param string $test
     * @return bool
     */
    public function hasTestInStore(string $test): bool;

    /**
     * @return array
     */
    public function getTestsFromStore(): array;

    /**
     * @param string $test
     * @return string
     */
    public function getVariantFromStore(string $test): null | string;

    /**
     * @param Test $test
     * @return VariantContract
     */
    public function getVariant(TestContract $test): VariantContract;

    /**
     * @param Test $test
     * @param Session $session
     * @return void
     */
    public function loadTestToStore(TestContract $test, Session $session): void;

    /**
     * @param Session $session
     * @return void
     */
    public function loadTestsToStore(Session $session): void;

    public function isTestRunnable(TestContract $test): bool;

    public function isTestStoppable(TestContract $test): bool;

    public function startTest(TestContract $test): void;

    public function stopTest(TestContract $test): void;

    /**
     * @param Session $session
     * @return array
     */
    public function removeStoppedTestsFromSTore(Session $session): array;
}
