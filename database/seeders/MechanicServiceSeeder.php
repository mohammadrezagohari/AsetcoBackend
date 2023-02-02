<?php

namespace Database\Seeders;

use App\Enums\MechanicTypes;
use App\Enums\RoleTypes;
use App\Models\Car;
use App\Models\Location;
use App\Models\Mechanic;
use App\Models\Mechanicaddress;
use App\Models\Role;
use App\Models\Service;
use App\Models\Servicecategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Sanctum\Sanctum;

class MechanicServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        Mechanicaddress::factory()->count(100)->create();
        // Get all the roles attaching up to 3 random roles to each user
        $services = Service::all();
        $mechanics = Mechanic::all();
        foreach ($mechanics as $mechanic) {
            if ($mechanic->type == MechanicTypes::BOTH) {
                Location::factory()->create([
                    'mechanic_id' => $mechanic->id,
                    'type' => MechanicTypes::BOTH
                ]);
            } else {
                Location::factory()->create([
                    'mechanic_id' => $mechanic->id,
                ]);
            }
            $role_mechanic = Role::whereName(RoleTypes::MECHANIC)->first()->pluck('id')->toArray();
            $mechanic->User->roles()->sync($role_mechanic);
            $mechanic->Services()->attach(
                $services->random(rand(4, 8))->pluck('id')->toArray(),
                [
                    'status' => rand(0, 1),
                    'price' => rand(100000, 5000000),
                ]
            );
        }
    }
}
