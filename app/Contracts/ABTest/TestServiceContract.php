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
     * Check the given string contains in the store as a key.
     *
     * @param string $test
     * @return bool
     */
    public function hasTestInStore(string $test): bool;

    /**
     * Returns all test - selected variant pairs from the store
     *
     * @return array
     */
    public function getTestsFromStore(): array;

    /**
     * Return a variant from the store by the AB test's name
     *
     * @param string $test
     * @return string
     */
    public function getVariantFromStore(string $test): null | string;

    /**
     * Get a variant from the AB test's variant
     *
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
     * Finds the active running AB tests and store the selected variants into the store.
     *
     * @param Session $session
     * @return void
     */
    public function loadTestsToStore(Session $session): void;

    /**
     * Check the given test is in a runnable status
     *
     * @param TestContract $test
     * @return bool
     */
    public function isTestRunnable(TestContract $test): bool;

    /**
     * Check the given test is in a stoppable status
     *
     * @param TestContract $test
     * @return bool
     */
    public function isTestStoppable(TestContract $test): bool;

    /**
     * Starts the given test, if it is in runnable status
     *
     * @param TestContract $test
     * @return void
     */
    public function startTest(TestContract $test): void;

    /**
     * Starts the given test, if it is in runnable status
     *
     * @param TestContract $test
     * @return void
     */
    public function stopTest(TestContract $test): void;

    /**
     * Removes the tests from the store, that  are not in runnable state or not found
     *
     * @param Session $session
     * @return array
     */
    public function removeStoppedTestsFromSTore(Session $session): array;
}
