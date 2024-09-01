<?php

namespace App\Contracts\ABTest\Model;

interface VariantContract
{
    /**
     * Returns the variant's name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the variant's target ratio
     *
     * @return int
     */
    public function getTargetRatio(): int;
}
