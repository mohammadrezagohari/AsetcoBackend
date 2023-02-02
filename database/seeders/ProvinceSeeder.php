<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path()."/database/seeders/data/provinces.json";

        $provinces = json_decode(file_get_contents($path));

        foreach ($provinces as $province) {
            Province::create([
               'id' => $province->id,
                'name' => $province->name
            ]);
        }
    }
}
