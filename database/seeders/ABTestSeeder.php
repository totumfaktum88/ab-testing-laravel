<?php

namespace Database\Seeders;

use App\Enums\ABTest\TestStatusEnum;
use App\Models\ABTest\Test;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ABTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Test::create([
            'displayed_name' => 'Landing animation',
            'name' => 'landing-animation',
            'status' => TestStatusEnum::RUNNING
        ])->variants()->createMany([
            ['name' => 'delorean', 'target_ratio' => 0.3],
            ['name' => 'millennium-falcon', 'target_ratio' => 0.2],
            ['name' => 'basic', 'target_ratio' => 0.5]
        ]);

        Test::create([
            'displayed_name' => 'Testing contact alignment',
            'name' => 'contact-alignment',
            'status' => TestStatusEnum::RUNNING
        ])->variants()->createMany([
            ['name' => 'map-top-form-right', 'target_ratio' => 0.25],
            ['name' => 'map-bottom-form-left', 'target_ratio' => 0.25],
            ['name' => 'map-hidden-form-right', 'target_ratio' => 0.25],
            ['name' => 'map-hidden-form-left', 'target_ratio' => 0.25]
        ]);

        Test::create([
            'displayed_name' => 'Testing pricing alignment',
            'name' => 'pricing-alignment',
            'status' => TestStatusEnum::RUNNING
        ])->variants()->createMany([
            ['name' => 'after-about-us', 'target_ratio' => 0.5],
            ['name' => 'before-faq', 'target_ratio' => 0.6]
        ]);

        Test::create([
            'displayed_name' => 'Testing pricing button labels',
            'name' => 'pricing-button-labels',
            'status' => TestStatusEnum::RUNNING
        ])->variants()->createMany([
            ['name' => 'Shutup and Take My Money!', 'target_ratio' => 0.2],
            ['name' => 'I give a try', 'target_ratio' => 0.2],
            ['name' => 'Buy Now', 'target_ratio' => 0.6]
        ]);

        Test::create([
            'displayed_name' => 'Testing feature types',
            'name' => 'feature-types',
            'status' => TestStatusEnum::RUNNING
        ])->variants()->createMany([
            ['name' => 'tabs', 'target_ratio' => 0.2],
            ['name' => 'services', 'target_ratio' => 0.4],
        ]);
    }
}
