<?php

namespace App\Contracts\ABTest;

use App\Contracts\ABTest\Model\VariantContract;

interface RandomSelectorContract
{
    /**
     * Add an item to the selector's collection
     *
     * @param VariantContract $item
     * @return void
     */
    public function addItem(VariantContract $item): void;

    /**
     * Remove an item to the selector's collection
     *
     * @param VariantContract $item
     * @return void
     */
    public function removeItem(VariantContract $item): void;

    /**
     * Remove all items from the selector's collection
     * @return void
     */
    public function flush(): void;

    /**
     * Create a random number between 0.01 and 1
     *
     * @return float
     */
    public function generateRandomNumber(): float;

    /**
     * Creates the threshold levels for the random variant selection based on the variant's target ratios
     * @return array
     */
    public function createThresholds(): array;

    /**
     * Choose a variant from the collection by random variant selection
     * @return VariantContract
     */
    public function selectVariant(): VariantContract;
}
