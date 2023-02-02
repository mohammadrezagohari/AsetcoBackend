<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\MechanicTypes;
use App\Enums\RoleTypes;
use App\Models\Location;
use App\Models\Mechanic;
use App\Models\Role;
use App\Models\User;
use App\Models\Userlocation;
use Database\Factories\UseraddressFactory;
use Database\Factories\UserlocationFactory;
use Illuminate\Database\Seeder;

class AdminTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'محمدرضا گوهری',
            'email' => 'eng.mr.gohari@gmail.com',
            'mobile' => '09117184875',
            'activated' => 1,
            'password' => \Hash::make('13721372'), // password
            'gender' => Gender::MALE,
            'national_identity' => 2080540890,
        ]);
        $mechanic = Mechanic::factory()->create([
            'type' => MechanicTypes::BOTH,
            'full_name' => 'محمدرضا گوهری',
            'name' => 'مکانیکی اوس ممد',
            'phone' => '09117184875',
            'activated' => true,
            'user_id' => $admin->id
        ]);
        Location::factory()->create([
            'mechanic_id' => $mechanic->id,
        ]);
        $admin1 = User::create([
            'name' => 'مصباح امامی',
            'email' => 'mesbah.asetco@gmail.com',
            'mobile' => '09025050634',
            'activated' => 1,
            'password' => \Hash::make('13731373'), // password
            'gender' => Gender::MALE,
            'national_identity' => 2080540891,
        ]);
        $mechanic1 = Mechanic::factory()->create([
            'type' => MechanicTypes::BOTH,
            'full_name' => 'مصباح امامی',
            'name' => 'اوس مصباح',
            'phone' => '09025050634',
            'activated' => true,
            'user_id' => $admin1->id
        ]);
        Location::factory()->create([
            'mechanic_id' => $mechanic1->id,
        ]);
        $admin2 = User::create([
            'name' => 'یاسمن سعیدی',
            'email' => 'asetco_saeedi@gmail.com',
            'mobile' => '09308814121',
            'activated' => 1,
            'password' => \Hash::make('11223344'), // password
            'gender' => Gender::FEMALE,
            'national_identity' => 2080540892,
        ]);
        $mechanic2 = Mechanic::factory()->create([
            'type' => MechanicTypes::BOTH,
            'full_name' => 'یاسمن سعیدی',
            'name' => 'یاسمن سعیدی',
            'phone' => '09308814121',
            'activated' => true,
            'user_id' => $admin2->id
        ]);

        Location::factory()->create([
            'mechanic_id' => $mechanic2->id,
        ]);
        $roles = Role::whereIn('name', [RoleTypes::SUPER_ADMIN, RoleTypes::ADMIN, RoleTypes::MECHANIC])->pluck('id')->toArray();
        $admin->roles()->sync($roles);
        $admin1->roles()->sync($roles);
        $admin2->roles()->sync($roles);
    }
}
