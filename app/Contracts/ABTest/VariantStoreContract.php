<?php

namespace App\Contracts\ABTest;

interface VariantStoreContract
{
    /**
     * @param string $key
     * @return string|null
     */
    public function get(string $key): string | null;

    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function put(string $key, string $value): void;

    /**
     * @param array $elements
     * @return void
     */
    public function forget(array $elements): void;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;
}
