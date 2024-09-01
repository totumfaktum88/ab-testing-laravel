<?php

namespace App\Contracts\ABTest;

interface VariantStoreContract
{
    /**
     * Returns a variant of the test from the store by the test name
     * @param string $key
     * @return string|null
     */
    public function get(string $key): string | null;

    /**
     * Returns all of the tests from the store
     * @return array
     */
    public function getAll(): array;

    /**
     * Puts a test / variant key - value pair into the store
     * If the test already stored, it will replaced with the new value
     * @param string $key
     * @param string $value
     * @return void
     */
    public function put(string $key, string $value): void;

    /**
     * Removes one or more tests from the store
     *
     * @param array $elements
     * @return void
     */
    public function forget(array $elements): void;

    /**
     * Checks the store contains the test
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;
}
