<?php

namespace Database\Factories;

use App\Models\Carmodel;
use App\Models\Color;
use App\Models\Service;
use App\Models\User;
use App\Models\Year;
use App\Models\Yourcar;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class YourcarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Yourcar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $Carmodel = Carmodel::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $year = Year::inRandomOrder()->first();
        $color = Color::inRandomOrder()->first();
        return [
            'pelak' => Str::slug($this->faker->randomNumber(6)),
            'carmodel_id' => $Carmodel->id,
            'year_id' => $year->id,
            'user_id' => $user->id,
            'color_id' => $color->id,
        ];
    }
}
