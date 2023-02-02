<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = City::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $province = Car::inRandomOrder()->first();

        return [
            "province_id" => $province->id,
            'name' => $this->faker->city,
            'name_en' => $this->faker->city,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }

}
