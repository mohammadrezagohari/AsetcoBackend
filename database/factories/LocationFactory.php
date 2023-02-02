<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Mechanic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;
    public $mechanic_id;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $mechanic = Mechanic::inRandomOrder()->first();
        return [
            "lat" => $this->faker->latitude(36.4, 36.6),
            "lon" => $this->faker->longitude(53.01, 53.02),
            "support_space" => rand(8, 20),
            "mechanic_id" => @$this->mechanic_id ? $this->mechanic_id : $mechanic->id,
            "type" => $mechanic->type,
        ];
    }
}
