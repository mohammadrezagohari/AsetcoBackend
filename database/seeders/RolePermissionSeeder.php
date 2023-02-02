<?php

namespace Database\Seeders;

use App\Enums\PermissionTypes;
use App\Enums\RoleTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleTypes = RoleTypes::ALL;
        $permissionType = PermissionTypes::ALL;
        //create roles.
        foreach($roleTypes as $roleName) {
            Role::create(['name' => $roleName]);
        }
        //create permissions.
        foreach($permissionType as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        $superAdminRole = Role::where('name', RoleTypes::SUPER_ADMIN)->first();

        //assign permissions to super admin role.
        $superAdminRole->permissions()->sync([1, 2, 3, 4, 5, 6, 7]);

        //assign permissions to admin role.
        $adminRole = Role::where('name', RoleTypes::ADMIN)->first();

        $adminRole->permissions()->sync([3, 4, 5, 6, 7]);
    }
}
