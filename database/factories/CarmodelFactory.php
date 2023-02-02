<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Carmodel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarmodelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Carmodel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $car = Car::inRandomOrder()->first();
        return [
            'name' => \Str::slug($this->faker->company),
            'car_id' => $car->id,
        ];
    }


}
