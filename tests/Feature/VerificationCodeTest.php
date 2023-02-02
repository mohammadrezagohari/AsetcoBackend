<?php

namespace Tests\Feature;

use App\Enums\RoleTypes;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VerificationCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user, ['*']);
        Artisan::call('db:seed RolePermissionSeeder');
        Artisan::call('db:seed ProvinceSeeder');
        Artisan::call('db:seed CitySeeder');
        User::factory()->count(10)->create();
        $role = Role::whereName(RoleTypes::MECHANIC)->firstOrFail();
        $this->user->roles()->sync(array($role->id));

        $this->withoutExceptionHandling();
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

//        Artisan::call('db:seed --class=RolePermissionSeeder');
        $role = Role::first();
        $this->user->roles()->sync(array($role->id));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_send_verification_code()
    {
        $this->withoutExceptionHandling();
        $response = $this->post(route('verification.send'), [
            'mobile' => '09397637499',
            'role' => RoleTypes::MECHANIC
        ]);
        $response->assertStatus(200);
    }

//    public function test_verify_verification_code()
//    {
//        $verificationCode = $this->user->verificationCodes()->create();
//
//        $response = $this->post(route('verification.verify'), [
//            'code' => $verificationCode->code,
//            'role' => RoleTypes::MECHANIC
//        ]);
//
//        $response->assertStatus(200);
//    }
}
