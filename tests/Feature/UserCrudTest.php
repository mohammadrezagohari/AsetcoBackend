<?php

namespace Tests\Feature;

use App\Enums\Gender;
use App\Enums\RoleTypes;
use App\Models\City;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Tests\TestCase;

class UserCrudTest extends TestCase
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
        $role = Role::whereName(RoleTypes::SUPER_ADMIN)->firstOrFail();
        $this->user->roles()->sync(array($role->id));
        $this->withoutExceptionHandling();
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
//        Artisan::call('db:seed --class=ProvinceSeeder');
//        Artisan::call('db:seed --class=CitySeeder');
    }

    public function test_user_can_be_stored()
    {
        $this->withoutExceptionHandling();
//        Storage::fake();
        $response = $this->post(route('user.store'), [
            'name' => 'mohammadrezagohari',
            'email' => 'eng.mr.gohari@gmail.com',
            'mobile' => '09117184875',
            'national_identity' => '2080566318',
            'gender' => Gender::MALE,
            'password' => 'current password',
            'c_password' => 'current password',
            'activated' => 1,
            'province_id' => '1',
            'city_id' => '1',
            'detail_address' => 'sea road',
//            'avatar'            => UploadedFile::fake()->image('photo.jpg')
        ]);

        $response->assertStatus(HTTPResponse::HTTP_OK);

//        $this->assertCount(2, User::all());
    }

    public function test_user_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $user = User::firstOrFail();
        $response = $this->put(route('user.update', $user->id), [
            'name' => 'mohammadreza gohari',
            'email' => 'eng.mr.gohari@hotmail.com',
            'mobile' => '09906844557',
            'national_identity' => '2080566318',
            'gender' => Gender::MALE,
            'password' => 'current password',
            'c_password' => 'current password',
            'activated' => 1,
            'province_id' => '1',
            'city_id' => '1',
            'detail_address' => 'sea road',
        ]);
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_user_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $user = User::firstOrFail();
        $response = $this->delete(route('user.delete', $user->id));
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_user_table()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('user.all'));

        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_user_profile()
    {
        $this->withoutExceptionHandling();
        $user = User::firstOrFail();
        $response = $this->get(route('user.profile', $user->id));
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

}
