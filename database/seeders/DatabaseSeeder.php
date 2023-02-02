<?php

namespace Database\Seeders;

use App\Enums\DaysOfTheWeek;
use App\Enums\VehicleTypes;
use App\Models\Attrproduct;
use App\Models\Carmodel;
use App\Models\Color;
use App\Models\Dailywork;
use App\Models\Location;
use App\Models\Mechanic;
use App\Models\Problem;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Models\Year;
use App\Models\Yourcar;
use Database\Factories\UseraddressFactory;
use Database\Factories\UserlocationFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
//            MediaSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            RolePermissionSeeder::class,
            AdminTestSeeder::class,
            UserSeeder::class,
            CarSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            ProductSeeder::class,
            MechanicServiceSeeder::class,
            ProblemSeeder::class,
            YourcarSeeder::class,
        ]);
    }
}
