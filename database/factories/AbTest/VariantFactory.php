<?php

namespace Database\Factories\AbTest;

use App\Enums\ABTest\TestStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'target_ratio' => $this->faker->randomFloat(.2, .5)
        ];
    }
}
