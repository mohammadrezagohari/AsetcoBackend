<?php

namespace Database\Factories;

use App\Models\Servicecategory;
use App\Models\User;
use App\Models\Useraddress;
use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class UseraddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Useraddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_table = User::inRandomOrder()->first();
        $province_table = Province::inRandomOrder()->first();
        $city_table = City::whereId($province_table->id)->inRandomOrder()->first();

        return [
            "street" => $this->faker->streetAddress,
            "alley" => $this->faker->name,
            "flat" => $this->faker->numberBetween(1000, 20000000000),
            "detail_address" => $this->faker->address,
            "lat" => $this->faker->latitude,
            "lon" => $this->faker->longitude,
            "province_id" => $province_table->id,
            "city_id" => $city_table->id,
            "user_id" => $user_table->id,
        ];
    }

}
