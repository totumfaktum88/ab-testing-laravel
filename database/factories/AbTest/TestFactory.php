<?php

namespace Database\Factories\AbTest;

use App\Enums\ABTest\TestStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'displayed_name' => $this->faker->name(),
            'name' => Str::snake($this->faker->name()),
            'status' => $this->faker->randomElements(TestStatusEnum::cases())
        ];
    }
}
