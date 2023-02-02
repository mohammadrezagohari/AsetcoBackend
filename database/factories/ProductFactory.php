<?php

namespace Database\Factories;

use App\Models\Carmodel;
use App\Models\Product;
use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $carmodel = Carmodel::inRandomOrder()->first();
        $year = Year::inRandomOrder()->first();
        return [
            'subject' => \Str::slug($this->faker->company),
            'price' => $this->faker->randomNumber(6),
            'carmodel_id' => $carmodel->id,
            'year_id' => $year->id
        ];
    }
}
