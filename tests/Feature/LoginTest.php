<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    private $user;
    /**
     * Setup the test environment.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = User::factory()->create();
        Artisan::call('db:seed --class=RolePermissionSeeder');
        $role = Role::first();
        $this->user->roles()->sync(array($role->id));
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $response = $this->post(route('login'), [
            'mobile' => $this->user->mobile,
            'password' => '12345678',
            'role_id' => Role::first()->id
        ]);

        $response->assertSuccessful();

        $token = json_decode($response->getContent())->token;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->post(route('test-token'));

        $response->assertSuccessful();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unregistered_user_can_not_login()
    {

        $response = $this->post(route('login'), [
            'mobile' => $this->user->mobile,
            'password' => '123456789',
            'role_id' => Role::first()->id
        ]);

        $response->assertStatus(400);
    }

    public function test_user_can_logout()
    {
        $response = $this->post(route('login'), [
            'mobile' => $this->user->mobile,
            'password' => '12345678',
            'role_id' => Role::first()->id
        ]);

        $token = json_decode($response->getContent())->token;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json'
        ])->post(route('logout'));

        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json'
        ])->post(route('test-token'));

        $response->assertSuccessful();
    }
}
