<?php

namespace App\Contracts\ABTest\Model;

use App\Enums\ABTest\TestStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface TestContract
{
    /**
     * Returns the Test's name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Updates test's status based on TestStatusEnum
     *
     * @param TestStatusEnum $status
     * @return bool
     */
    public function updateStatus(TestStatusEnum $status): bool;

    /**
     * Returns the eloquent relation of the test variants
     *
     * @return HasMany
     */
    public function variants(): HasMany;

    /**
     * Returns a query builder, that returns the tests in running status
     *
     * @param Builder $query
     * @return void
     */
    public function scopeByRunning(Builder $query): void;

    /**
     * Returns a query builder, that returns the tests in stopped status
     *
     * @param Builder $query
     * @return void
     */
    public function scopeByStopped(Builder $query): void;
}
