<?php

namespace Database\Factories;

use App\Models\Province;
use Faker\Provider\fa_IR\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinceFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Province::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'country' => $this->faker->unique()->numberBetween(1, 100),
            'name'    => $this->faker->city,
            'name_en' => $this->faker->city,
        ];
    }
}
