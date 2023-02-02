<?php

namespace Tests\Feature;

use App\Enums\MechanicTypes;
use App\Enums\VehicleTypes;
use App\Models\City;
use App\Models\Mechanic;
use App\Models\Province;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MobileMechanicCrudTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var User
     */
    protected $user;
    /**
     * @var User
     */
    protected $currentUser;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void {
        parent::setUp();
//        Artisan::call('db:seed ');
        $this->user = User::factory()->create();
        User::factory()->count(1)->create();
        $this->currentUser = User::latest()->first();
        Sanctum::actingAs($this->user, ['*']);
        $this->withoutExceptionHandling();
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mobile_mechanic_can_be_created()
    {
        $response = $this->post(route('mechanic.mobile.store', $this->currentUser), [
            'type_vehicle' => VehicleTypes::MOTORCYCLE,
            'pelak'        => '66ب662-62'
        ]);

        $this->assertCount(1, Mechanic::all());

        $response->assertSuccessful();
    }

    public function test_mobile_mechanic_can_be_updated()
    {
        $this->currentUser->mechanic()->create([
            'type'         => MechanicTypes::MOBILE,
            'type_vehicle' => VehicleTypes::MOTORCYCLE,
            'pelak'        => '66ب662-62'
        ]);

        $mechanic = $this->currentUser->mechanic;

        $response = $this->put(route('mechanic.mobile.update', [$this->currentUser, $mechanic]), [
            'type_vehicle' => VehicleTypes::CAR,
            'pelak'        => '77ب663-63'
        ]);

        $this->assertCount(1, Mechanic::all());

        $response->assertSuccessful();
    }

    public function test_mobile_mechanic_can_be_deleted()
    {
        $this->currentUser->mechanic()->create([
            'type'         => MechanicTypes::MOBILE,
            'type_vehicle' => VehicleTypes::MOTORCYCLE,
            'pelak'        => '66ب662-62'
        ]);

        $mechanic = $this->currentUser->mechanic;

        $response = $this->delete(route('mechanic.mobile.delete', [$this->currentUser, $mechanic]));

        $response->assertSuccessful();

        $this->assertCount(0, Mechanic::all());
    }

    public function test_get_mobile_mechanic()
    {
        $this->currentUser->mechanic()->create([
            'type'         => MechanicTypes::MOBILE,
            'type_vehicle' => VehicleTypes::MOTORCYCLE,
            'pelak'        => '66ب662-62'
        ]);

        $mechanic = $this->currentUser->mechanic;

        $response = $this->get(route('mechanic.mobile.show', [$this->currentUser, $mechanic]));

        $response->assertSuccessful();

    }

    public function test_get_mobile_mechanics_list()
    {
        $response = $this->get(route('mechanic.mobile.list', $this->currentUser));

        $response->assertSuccessful();
    }
}
