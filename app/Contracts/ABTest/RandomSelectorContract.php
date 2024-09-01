<?php

namespace App\Contracts\ABTest;

use App\Contracts\ABTest\Model\VariantContract;

interface RandomSelectorContract
{
    public function addItem(VariantContract $item): void;

    public function removeItem(VariantContract $item): void;

    public function flush(): void;

    public function generateRandomNumber(): float;

    public function createThresholds(): array;

    public function selectVariant(): VariantContract;
}
