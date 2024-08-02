<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<DeviceGroup> */
class DeviceGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->domainWord(),
            'desc' => $this->faker->text(255),
            'type' => 'static',
        ];
    }
}
