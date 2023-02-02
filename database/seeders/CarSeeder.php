<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Carmodel;
use App\Models\City;
use App\Models\Color;
use App\Models\Year;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path() . "/database/seeders/data/cars.json";
        $cars = json_decode(file_get_contents($path));
        foreach ($cars as $car) {
            Car::create([
                'brand' => $car->brand,
            ]);
        }
        Color::factory()->count(50)->create();
        Carmodel::factory()->count(50)->create();
        Year::factory()->count(20)->create();
    }
}
