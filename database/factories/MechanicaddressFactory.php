<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Location;
use App\Models\Mechanic;
use App\Models\Mechanicaddress;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class MechanicaddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mechanicaddress::class;

    public function definition()
    {
        $province = Province::inRandomOrder()->first();
        $city = City::inRandomOrder()->first();
//        $mechanic = Mechanic::inRandomOrder()->first();
        $mechanic = $this->mechanic_table();
        return [
            "street" => $this->faker->streetAddress,
            "alley" => $this->faker->name,
            "flat" => $this->faker->numberBetween(1000, 20000000000),
            "detail_address" => $this->faker->address,
            "province_id" => $province->id,
            "city_id" => $city->id,
            "mechanic_id" => $mechanic::factory(),
        ];
    }

    public function mechanic_table()
    {
        return $this->faker->randomElement([
            Mechanic::class,
        ]);
    }
}
