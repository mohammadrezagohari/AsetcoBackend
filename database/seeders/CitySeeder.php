<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $path = base_path()."/database/seeders/data/cities.json";
        $cities = json_decode(file_get_contents($path));
        foreach ($cities as $city) {
            City::create([
                'id' => $city->id,
                'name' => $city->name,
                'province_id' => $city->province_id
            ]);
        }
    }
}
