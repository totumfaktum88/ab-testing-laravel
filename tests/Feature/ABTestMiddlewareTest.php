<?php

namespace Tests\Feature;

use App\Contracts\ABTest\TestServiceContract;
use App\Contracts\ABTest\VariantStoreContract;
use App\Enums\ABTest\TestStatusEnum;
use App\Enums\Session\EventTypeEnum;
use App\Models\ABTest\Test;
use App\Models\ABTest\Variant;
use App\Models\Event;
use Tests\TestCase;

class ABTestMiddlewareTest extends TestCase
{
    public function testMiddlewareAssignsABTestVariant(): void
    {
        $test = Test::factory()->state(['status' => TestStatusEnum::RUNNING])->has(Variant::factory()->count(2)->sequence(
            ['name' => 'A', 'target_ratio' => 1],
            ['name' => 'B', 'target_ratio' => 1]
        ), 'variants')->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        $store = $this->app->make(VariantStoreContract::class);

        $this->assertTrue($store->has($test->name));
        $this->assertContains($store->get($test->name), $test->variants->pluck('name')->toArray());
    }

    public function testMiddlewareAssignsMultipleABTestVariant(): void
    {
        $test1 = Test::factory()->state(['status' => TestStatusEnum::RUNNING])->has(Variant::factory()->count(2)->sequence(
            ['name' => 'A', 'target_ratio' => 1],
            ['name' => 'B', 'target_ratio' => 1]
        ), 'variants')->create();

        $test2 = Test::factory()->state(['status' => TestStatusEnum::RUNNING])->has(Variant::factory()->count(2)->sequence(
            ['name' => 'C', 'target_ratio' => 1],
            ['name' => 'D', 'target_ratio' => 1]
        ), 'variants')->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        $store = $this->app->make(VariantStoreContract::class);

        $this->assertTrue($store->has($test1->name));
        $this->assertContains($store->get($test1->name), $test1->variants->pluck('name')->toArray());

        $this->assertTrue($store->has($test2->name));
        $this->assertContains($store->get($test2->name), $test2->variants->pluck('name')->toArray());
    }


    public function testStoredABTestVariantConsist(): void
    {
        $test = Test::factory()->state(['status' => TestStatusEnum::RUNNING])->has(Variant::factory()->count(2)->sequence(
            ['name' => 'A', 'target_ratio' => 1],
            ['name' => 'B', 'target_ratio' => 1]
        ), 'variants')->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        $store = $this->app->make(VariantStoreContract::class);

        $this->assertTrue($store->has($test->name));
        $this->assertContains($store->get($test->name), $test->variants->pluck('name')->toArray());

        $variant = $store->get($test->name);

        $response = $this->get('/');

        $response->assertStatus(200);

        $this->assertEquals($variant, $store->get($test->name));
    }

    public function testMultipleStoredABTestVariantConsist(): void
    {
        $test1 = Test::factory()->state(['status' => TestStatusEnum::RUNNING])->has(Variant::factory()->count(2)->sequence(
            ['name' => 'A', 'target_ratio' => 1],
            ['name' => 'B', 'target_ratio' => 1]
        ), 'variants')->create();

        $test2 = Test::factory()->state(['status' => TestStatusEnum::RUNNING])->has(Variant::factory()->count(2)->sequence(
            ['name' => 'C', 'target_ratio' => 1],
            ['name' => 'D', 'target_ratio' => 1]
        ), 'variants')->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        $store = $this->app->make(VariantStoreContract::class);


        $this->assertTrue($store->has($test1->name));
        $this->assertContains($store->get($test1->name), $test1->variants->pluck('name')->toArray());

        $this->assertTrue($store->has($test2->name));
        $this->assertContains($store->get($test2->name), $test2->variants->pluck('name')->toArray());

        $variant1 = $store->get($test1->name);
        $variant2 = $store->get($test2->name);

        $response = $this->get('/');

        $response->assertStatus(200);

        $this->assertEquals($variant1, $store->get($test1->name));
        $this->assertEquals($variant2, $store->get($test2->name));
    }



    public function testStartABTest(): void
    {
        $test = Test::factory()->state(['status' => TestStatusEnum::CREATED])->has(Variant::factory()->count(2)->sequence(
            ['name' => 'A', 'target_ratio' => 1],
            ['name' => 'B', 'target_ratio' => 1]
        ), 'variants')->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        $store = $this->app->make(VariantStoreContract::class);

        $this->assertFalse($store->has($test->name));

        $service = $this->app->make(TestServiceContract::class);

        $service->startTest($test);

        $response = $this->get('/');

        $response->assertStatus(200);

        $this->assertTrue($store->has($test->name));
        $this->assertContains($store->get($test->name), $test->variants->pluck('name')->toArray());
    }

    public function testStopABTest(): void
    {
        $test = Test::factory()->state(['status' => TestStatusEnum::RUNNING])->has(Variant::factory()->count(2)->sequence(
            ['name' => 'A', 'target_ratio' => 1],
            ['name' => 'B', 'target_ratio' => 1]
        ), 'variants')->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        $store = $this->app->make(VariantStoreContract::class);

        $this->assertTrue($store->has($test->name));
        $this->assertContains($store->get($test->name), $test->variants->pluck('name')->toArray());

        $service = $this->app->make(TestServiceContract::class);

        $service->stopTest($test);

        $response = $this->get('/');

        $response->assertStatus(200);

        $this->assertTrue($store->has($test->name));
    }

    public function testWeightedRandomSelection(): void {
        $test = Test::factory()->state(['status' => TestStatusEnum::RUNNING])->has(Variant::factory()->count(4)->sequence(
            ['name' => 'A', 'target_ratio' => 4],
            ['name' => 'B', 'target_ratio' => 3],
            ['name' => 'C', 'target_ratio' => 2],
            ['name' => 'D', 'target_ratio' => 1]
        ), 'variants')->create();

        for($i = 0; $i <= 500; $i++) {
            $response = $this->get('/');

            $response->assertStatus(200);

            session()->flush();
        }

        $variants = $test->variants()->orderBy('id', 'asc')->get();
        $variantStats = Event::query()
            ->where('type', EventTypeEnum::TEST_INITIALIZED->value)
            ->whereJsonContains('data->test_name', $test->name)
            ->get();

        $totalRatio = $variants->sum(fn($i) => $i->getTargetRatio());
        $totalCount = $variantStats->count();
        $tolerance = 5;

        foreach($variants as $k => $variant) {
            $count = $variantStats->filter(fn($d) => $d['data']['variant_name'] == $variant->name)->count();

            $percentage = ($count / $totalCount) * 100;
            $expectedPercentage = ($variant->getTargetRatio() / $totalRatio) * 100;

            $this->assertEqualsWithDelta($expectedPercentage, $percentage, $tolerance);
        }
    }
}
