<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RoleCrudeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp(): void {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
        $this->withoutExceptionHandling();
        Artisan::call('db:seed ');

        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

//        Artisan::call('db:seed --class=RolePermissionSeeder');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_role_can_be_stored()
    {
        $response = $this->post(route('role.store'),[
            'name' => 'manager',
            'permission_ids' => [1, 2, 3, 4]
        ]);
        $response->assertSuccessful();
    }

    public function test_role_can_be_updated()
    {
        $response = $this->put(route('role.update', Role::first()->id),[
            'name' => 'manager',
            'permission_ids' => [1, 2, 5]
        ]);
        $response->assertSuccessful();
    }

    public function test_role_can_be_deleted()
    {
        $response = $this->delete(route('role.update', Role::first()->id));
        $response->assertSuccessful();
    }
    public function test_role_can_be_viewed()
    {
        $response = $this->get(route('role.show', Role::first()->id));
        $response->assertSuccessful();
    }
    public function test_all_roles_can_be_retrieved()
    {
        $response = $this->get(route('role.index'));
        $response->assertSuccessful();
    }

    public function test_role_can_be_assigned()
    {
        $user = User::factory()->create();
        $response = $this->post(route('role.assign', [
            'user_id' => $user,
            'role_ids' => [1, 2, 3]
        ]));

        $this->assertCount(3, $user->roles);

        $response->assertStatus(200);
    }
}
