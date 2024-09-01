<?php

namespace App\Services\ABTest;

use App\Contracts\ABTest\Model\VariantContract;
use App\Contracts\ABTest\RandomSelectorContract;
use App\Exceptions\ABTest\InvalidNumberOfVariantsException;
use App\Exceptions\ABTest\InvalidVariantTypeException;
use Illuminate\Database\Eloquent\Collection;

class RandomSelector implements RandomSelectorContract
{
    protected Collection $items;

    public function __construct() {
        $this->items = new Collection();
    }

    public function generateRandomNumber(): float
    {
        return mt_rand(1, 100) / 100;
    }

    public function addItem(VariantContract $item): void
    {
        $this->items->add($item);
    }

    public function addItems(array | Collection $collection) {
        foreach($collection as $item) {
            if ($item instanceof VariantContract) {
                $this->addItem($item);
            }else {
                throw new InvalidVariantTypeException("Invalid variant type. Only ".VariantContract::class." accepted.");
            }
        }
    }

    public function removeItem(VariantContract $item): void
    {
        $this->item = $this->items->filter(fn($i) => $i === $item);
    }

    public function flush(): void
    {
        $this->items = new Collection();
    }

    public function createThresholds(): array {
        if ($this->items->count() <= 1) {
            throw new InvalidNumberOfVariantsException();
        }

        $totalRatio = $this->items->sum(fn($variant) => $variant->getTargetRatio());

        $diff = 1;

        if ($totalRatio != 1) {
            $diff = $diff / $totalRatio;
        }

        $currentThreshold = 0;
        $thresholds = [];

        foreach($this->items as $item){
            $modifiedRatio = $item->getTargetRatio() * $diff;

            $thresholds[] = $currentThreshold + $modifiedRatio;

            $currentThreshold += $modifiedRatio;
        }

        return $thresholds;
    }

    public function selectVariant(): VariantContract
    {
        $thresholds = $this->createThresholds();
        $number = $this->generateRandomNumber();
        $variant = $this->items->get(0);

        foreach ($thresholds  as $index => $item) {
            if ($number <= $item) {
                $variant = $this->items->get($index);
                break;
            }
        }

        return $variant;
    }
}
