<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Role;
use App\Models\Service;
use App\Models\Servicecategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Tests\TestCase;

class ServiceTest extends TestCase
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
        Artisan::call('db:seed ');
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
    }

    public function test_a_new_service_can_store()
    {
        $response = $this->post(route('services.store'), [
            "subject" => "تعویض روغن",
            "description" => "توضیحات اضافه",
            "price" => 8000000,
            "servicecategory_id" => 1,
            "carmodel_id" => 1,
        ]);
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_a_service_can_update()
    {
        $response = $this->patch(route('services.update', ['id' => 1]), [
            "subject" => "تعویض روغن",
            "description" => "توضیحات اضافه",
            "price" => 500000,
            "servicecategory_id" => 1,
            "carmodel_id" => 1,
        ]);
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_a_service_can_delete()
    {
        $response = $this->delete(route('services.delete', ['id' => 1]));
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }
}
