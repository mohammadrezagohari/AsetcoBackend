<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pathServices = base_path() . "/database/seeders/data/services.json";
        $services = json_decode(file_get_contents($pathServices));
        foreach ($services as $service) {
            Service::create([
                'subject' => $service->subject,
                'description' => $service->description,
                'price' => $service->price,
                'servicecategory_id' => $service->servicecategory_id,
                'carmodel_id' => $service->carmodel_id,
            ]);
        }
    }
}
