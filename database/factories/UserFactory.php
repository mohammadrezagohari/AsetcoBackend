<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\User;
use App\Models\Userlocation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Plank\Mediable\Media;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => '09' . strval(rand(100000000, 999999999)),
            'activated' => true,
            'password' => Hash::make('12345678'), // password
            'gender' => Gender::ALL[array_rand(Gender::ALL)],
            'national_identity' => strval(rand(1000000000, 9999999999)),
            'remember_token' => Str::random(10),
        ];
//        return [
//            'name' => 'mohammad reza gohari',
//            'email' => 'eng.mr.gohari@gmail.com',
//            'mobile' => '09117184875',
//            'activated' => 1,
//            'password' => Hash::make('12345678'), // password
//            'gender' => Gender::ALL[array_rand(Gender::ALL)],
//            'national_identity' => strval(rand(1000000000, 9999999999)),
//            'remember_token' => Str::random(10),
//        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): UserFactory
    {
        return $this->afterMaking(function (User $user) {
            //
        })->afterCreating(function (User $user) {
            if (Media::count()) {
                $media = Media::all()->random();
                $user->attachMedia($media, 'avatar');
            }
        });
    }
}
