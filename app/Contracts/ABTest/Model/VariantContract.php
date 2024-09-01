<?php

namespace App\Contracts\ABTest\Model;

interface VariantContract
{
    public function getName(): string;

    public function getTargetRatio(): float;
}
