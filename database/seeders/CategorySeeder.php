<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Servicecategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $path = base_path() . "/database/seeders/data/service_categories.json";
       $categories = json_decode(file_get_contents($path));
       foreach ($categories as $category) {
           Servicecategory::create([
               'category' => $category->category,
           ]);
       }

    }
}
