<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProblemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => \Str::slug($this->faker->jobTitle),
        ];
    }
}
