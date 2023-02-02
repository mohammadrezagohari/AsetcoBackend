<?php

namespace Database\Factories;

use App\Models\Attrproduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttrproductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attrproduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_table = Product::inRandomOrder()->first();
        return [
            'subject' => $this->faker->firstName,
            'value' => $this->faker->lastName,
            'product_id' => $product_table->id,
        ];
    }
}
