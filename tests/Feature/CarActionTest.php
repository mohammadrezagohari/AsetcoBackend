<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Tests\TestCase;

class CarActionTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        Car::factory()->create();
    }

    public function test_a_new_car_can_store()
    {
        $response = $this->post(route('car.store'), [
            'brand' => 'MWM',
        ]);
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_a_service_can_update()
    {
        $response = $this->patch(route('car.update', ['id' => 1]), [
            'brand' => 'KIA',
        ]);
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_a_car_can_delete()
    {
        $response = $this->delete(route('car.delete', ['id' => 1]));
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }


    public function test_user_request_car_order()
    {
        $response = $this->post(route('car.store'), [
            'brand' => 'MWM',
        ]);
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }


}
