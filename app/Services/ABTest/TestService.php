<?php

namespace App\Services\ABTest;

use App\Enums\Session\EventTypeEnum;
use App\Models\ABTest\Test;
use App\Models\ABTest\Variant;
use App\Models\Session;
use Illuminate\Contracts\Session\Session as SessionContract;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\Debug;

class TestService {

    private const SESSION_AB_TESTS_KEY = 'ab_tests';

    /**
     * @param SessionContract $sessionManager
     */
    public function __construct(
        private readonly SessionContract $sessionManager,
    ) {

    }

    /**
     * @param string $test
     * @return bool
     */
    public function hasTestForSession(string $test): bool {
        //dd($this->getTestsFromSession());
        return isset($this->getTestsFromSession()[$test]);
    }

    /**
     * @return array
     */
    public function getTestsFromSession(): array {
        $tests = $this->sessionManager->get(static::SESSION_AB_TESTS_KEY);

        return is_array($tests) ? $tests : [];
    }

    /**
     * @param Test $test
     * @param Variant $variant
     * @return void
     */
    protected function addTestsToSession(Test $test, Variant $variant): void {
        $tests = $this->sessionManager->get(static::SESSION_AB_TESTS_KEY);
        $tests[$test->name] = $variant->name;

        $this->sessionManager->put(static::SESSION_AB_TESTS_KEY, $tests);
    }

    /**
     * @param string $test
     * @return string
     */
    public function getVariantFromSession(string $test): null | string {
        if ($this->hasTestForSession($test)) {
            return $this->getTestsFromSession()[$test];
        } else {
            return null;
        }
    }

    /**
     * @param Test $test
     * @return int
     */
    protected function loadVariant(Test $test): null | Variant {
        $totalRatio = $test->sumVariantRatios();
        $variants = $test->variants()->byTargetRatio('desc')->get();

        $currentThreshold = 0;
        $ratios = [];

        $diff = 1;

        if ($totalRatio != 1) {
            $diff = $diff / $totalRatio;
        }

        foreach($variants as $variant){
            $modifiedRatio = $variant->target_ratio * $diff;

            $ratios[] = [
                'variant' => $variant,
                'target_ratio' => $variant->target_ratio,
                'threshold' => $currentThreshold + $modifiedRatio
            ];

            $currentThreshold += $modifiedRatio;
        }



        $random = mt_rand(1, 100) / 100;

        $variant = null;

        foreach ($ratios as $ratio) {
            if ($random <= $ratio['threshold']) {
                $variant = $ratio['variant'];
                break;
            }
        }

        if ($variant === null) {
            Log::debug(json_encode([$random, $diff, $ratios]));
        }

        return $variant;
    }

    /**
     * @param Test $test
     * @param Session $session
     * @return bool
     */
    public function loadTestForSession(Test $test, Session $session): bool {
        $variant = $this->loadVariant($test);

        if ($variant) {
            $this->addTestsToSession($test, $variant);

            $session->events()->create([
                'type' => EventTypeEnum::TEST_INITIALIZED,
                'data' => [
                    'test_id' => $test->id,
                    'test_name' => $test->name,
                    'variant_id' => $variant->id,
                    'variant_name' => $variant->name
                ]
            ]);

            return true;
        }else {
            return false;
        }
    }

    /**
     * @param Session $session
     * @return void
     */
    public function loadTestsForSession(Session $session): void {
        $this->removeStoppedTestsFromSession($session);

        $tests = Test::byRunning()->get();

        foreach($tests as $test) {
            if (!$this->hasTestForSession($test->name)) {
                $this->loadTestForSession($test, $session);
            }
        }
    }

    /**
     * @param Session $session
     * @return array
     */
    public function removeStoppedTestsFromSession(Session $session): array {
        $diff = [];

        if ($this->sessionManager->has(static::SESSION_AB_TESTS_KEY)) {
            $testsInSession = $this->sessionManager->get(static::SESSION_AB_TESTS_KEY);
            $testNames = array_keys($testsInSession);

            $tests = Test::query()->byStopped()->whereIn('name', $testNames)
                ->get()
                ->pluck('id')
                ->toArray();

            $diff = array_diff_key($testsInSession, $tests);
            $this->sessionManager->put(static::SESSION_AB_TESTS_KEY, $diff);

            foreach($tests as $test) {
                $session->events()->create([
                    'type' => EventTypeEnum::TEST_REMOVED,
                    'data' => [
                        'test_id' => $test->id,
                    ]
                ]);
            }
        }

        return $diff;
    }
}
