<?php

namespace App\Services\ABTest;

use App\Contracts\ABTest\Model\TestContract;
use App\Contracts\ABTest\Model\VariantContract;
use App\Contracts\ABTest\RandomSelectorContract;
use App\Contracts\ABTest\TestServiceContract;
use App\Contracts\ABTest\VariantStoreContract;
use App\Enums\ABTest\TestStatusEnum;
use App\Enums\Session\EventTypeEnum;
use App\Models\ABTest\Test;
use App\Models\ABTest\Variant;
use App\Models\Session;

class TestService implements TestServiceContract {

    /**
     * @param RandomSelectorContract $selector
     * @param VariantStoreContract $storeManager
     */
    public function __construct(
        protected readonly RandomSelectorContract $selector,
        protected readonly VariantStoreContract $storeManager,
    ) {

    }

    public function hasTestInStore(string $test): bool {
        return $this->storeManager->has($test);
    }

    public function getTestsFromStore(): array {
        return $this->storeManager->getAll();
    }

    protected function addTestsToStore(Test $test, Variant $variant): void {
        $this->storeManager->put($test->name, $variant->name);
    }

    public function getVariantFromStore(string $test): null | string {
        if ($this->hasTestInStore($test)) {
            return $this->getTestsFromStore()[$test];
        } else {
            return null;
        }
    }

    public function getVariant(TestContract $test): VariantContract {
        $this->selector->flush();

        $variants = $test->variants()->get();

        $this->selector->addItems($variants);

        return $this->selector->selectVariant();
    }

    public function isTestRunnable(TestContract $test): bool {
        return $test->status == TestStatusEnum::CREATED;
    }

    public function isTestStoppable(TestContract $test): bool {
        return $test->status == TestStatusEnum::RUNNING;
    }

    public function startTest(TestContract $test): void {
        if (!$this->isTestRunnable($test)) {

        }

        $test->updateStatus(TestStatusEnum::RUNNING);
    }

    public function stopTest(TestContract $test): void {
        if (!$this->isTestStoppable($test)) {

        }

        $test->updateStatus(TestStatusEnum::RUNNING);
    }

    public function loadTestToStore(TestContract $test, Session $session): void {
        $variant = $this->getVariant($test);
        $this->addTestsToStore($test, $variant);

        $session->events()->create([
            'type' => EventTypeEnum::TEST_INITIALIZED,
            'data' => [
                'test_name' => $test->name,
                'variant_name' => $variant->getName()
            ]
        ]);
    }

    public function loadTestsToStore(Session $session): void {
        $this->removeStoppedTestsFromStore($session);

        $tests = Test::byRunning()->get();

        foreach($tests as $test) {
            if (!$this->hasTestInStore($test->name)) {
                $this->loadTestToStore($test, $session);
            }
        }
    }

    public function removeStoppedTestsFromStore(Session $session): array {
        $diff = [];

        $testsInSession = $this->storeManager->getAll();

        $tests = Test::query()->byRunning()->whereIn('name', array_keys($testsInSession))
            ->get()
            ->pluck('name')
            ->toArray();

        $this->storeManager->forget(array_diff_key($testsInSession, $tests));

        foreach($tests as $test) {
            $session->events()->create([
                'type' => EventTypeEnum::TEST_REMOVED,
                'data' => [
                    'test_name' => $test,
                ]
            ]);
        }

        return $diff;
    }
}
