<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Userlocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserlocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Userlocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            "user_id" => $user->id,
            "lat" => $this->faker->latitude(36.4, 36.6),
            "lon" => $this->faker->longitude(53.01, 53.02),
        ];
    }
}
