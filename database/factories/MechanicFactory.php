<?php

namespace Database\Factories;

use App\Enums\LocationType;
use App\Enums\MechanicTypes;
use App\Enums\VehicleTypes;
use App\Models\Useraddress;
use App\Models\Mechanic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MechanicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mechanic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            'type' => $this->faker->randomElement(LocationType::ALL),
            'name' => $this->faker->name,
            'parts_supplier' => $this->faker->boolean,
            'full_name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'license' => $this->faker->numberBetween(10000, 100000000),
            'activated' => 1,
            'type_vehicle' => $this->faker->randomElement(VehicleTypes::ALL),
            'pelak' => \Str::slug($this->faker->numberBetween(10000, 100000000)),
            'count_available' => rand(1, 20),
            'user_id' => $user->id,
        ];
    }




}
