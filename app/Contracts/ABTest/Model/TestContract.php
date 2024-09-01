<?php

namespace App\Contracts\ABTest\Model;

use App\Enums\ABTest\TestStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface TestContract
{
    public function getName(): string;

    public function updateStatus(TestStatusEnum $status): bool;

    public function variants(): HasMany;

    public function scopeByRunning(Builder $query): void;

    public function scopeByStopped(Builder $query): void;

    public function sumVariantRatios(): float;
}
