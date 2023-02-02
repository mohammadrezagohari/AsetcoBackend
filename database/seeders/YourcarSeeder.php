<?php

namespace Database\Seeders;

use App\Enums\RoleTypes;
use App\Models\Carmodel;
use App\Models\Color;
use App\Models\Role;
use App\Models\User;
use App\Models\Year;
use App\Models\Yourcar;
use Illuminate\Database\Seeder;
use Faker\Factory;

class YourcarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = Role::whereName(RoleTypes::SUPER_ADMIN)->firstOrFail()->users;
        foreach ($users as $user) {
            $Carmodel = Carmodel::inRandomOrder()->first();
            $year = Year::inRandomOrder()->first();
            $color = Color::inRandomOrder()->first();
            $faker = Factory::create();
            $user->YourCars()->create([
                'pelak' => $faker->randomNumber(8),
                'carmodel_id' => $Carmodel->id,
                'year_id' => $year->id,
                'color_id' => $color->id,
            ]);
        }
        Yourcar::factory()->count(200)->create();
    }
}
