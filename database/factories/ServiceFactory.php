<?php

namespace Database\Factories;

use App\Models\Carmodel;
use App\Models\Service;
use App\Models\Servicecategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $carModel = Carmodel::inRandomOrder()->first();
        $serviceCategory = Servicecategory::inRandomOrder()->first();
        return [
            "subject" => $this->faker->name,
            "description" => $this->faker->realText,
            "price" => $this->faker->numberBetween(1000, 20000000000),
            "carmodel_id" => $carModel->id,
            "servicecategory_id" => $serviceCategory->id,
        ];
    }
}
