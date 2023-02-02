<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Mechanic;
use App\Models\Mechanicaddress;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ServiceMechanicTest extends TestCase {

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
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        Artisan::call('db:seed ');
        $services  = Service::all();
        $mechanics = Mechanic::all();
        foreach ($mechanics as $mechanic) {
            $mechanic->Services()->attach(
                $services->random(rand(1, 3))->pluck('id')->toArray(),
                [
                    'status' => rand(0, 1),
                    'price'  => rand(100000, 5000000),
                ]
            );
        };
    }

    public function test_service_list() {
        $response = $this->post(route('service.list'), [
            'car'     => 'nn',
            'service' => null,
        ]);
        $response->assertStatus(200);
    }

    public function test_service_for_a_mechanic_list() {
        $response = $this->post(route('service.find.mechain'), [
            'mechanic'     => 'a',
            'phone'        => null,
            'type'         => null,
            'type_vehicle' => null,
        ]);

        $response->assertStatus(200);
    }

    public function test_list_mechanic_for_service() {
        $response = $this->post(route('mechanics.find.service'), [
            'service' => 'ا',
        ]);

        $response->assertStatus(200);
    }

//    public function test_mechanic_list_near() {
//        $response = $this->post(route('mechanic.list.near'), [
//            'latitude'  => '37.09024',
//            'longitude' => '-95.712891',
//        ]);
//        $response->assertStatus(200);
//    }

    public function test_assign_mechanic_serve_service() {
        $response = $this->post(route('assign.mechanic.serve.service'), [
            'mechanic' => 1,
            'services' => [
                5 => [
                    'status' => true,
                    'price'  => 1088000,
                ],
                1 => [
                    'status' => false,
                    'price'  => 9000,
                ],
                2 => [
                    'status' => true,
                    'price'  => 80000,
                ],
            ],
        ]);

        $response->assertStatus(200);
    }


}
