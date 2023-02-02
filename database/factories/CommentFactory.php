<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Comment;
use App\Models\Mechanic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $mechanic = Mechanic::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        return [
            'accepted' => rand(0, 1),
            'context' => $this->faker->realText,
            'mechanic_id' => $mechanic->id,
            'user_id' => $user->id,
        ];
    }
}
