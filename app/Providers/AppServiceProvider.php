<?php

namespace App\Providers;

use App\Contracts\ABTest\RandomSelectorContract;
use App\Contracts\ABTest\TestServiceContract;
use App\Contracts\ABTest\VariantStoreContract;
use App\Services\ABTest\RandomSelector;
use App\Services\ABTest\TestService;
use App\Services\ABTest\VariantStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TestServiceContract::class, TestService::class);
        $this->app->bind(RandomSelectorContract::class, RandomSelector::class);
        $this->app->bind(VariantStoreContract::class, VariantStore::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
    }
}
