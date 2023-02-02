<?php

namespace Tests\Feature;


use App\Models\Attrproduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Tests\TestCase;

class ProductCrudTest extends TestCase
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

    public function test_a_new_product_can_store() {
        $response = $this->post(route('products.store'), [
            "subject" => "روغن موتور خودرو اسپیدی مدل",
            "price" => 800000,
            'carmodel_id' => 2,
            'year_id' => 2,
            "attributes" => [
                [
                    "subject" => "برند",
                    "value" => "اسپیدی",
                ],
                [
                    "subject" => "مدل",
                    "value" => "Power 10W-40",
                ],
                [
                    "subject" => "حجم",
                    "value"   => "4 لیتری",
                ],
            ],
        ]);

        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_a_product_can_update()
    {
        $response = $this->patch(route('products.update', 1), [
            "subject" => "آزمایش تغییر دارد",
            "price" => 800000,
            'carmodel_id' => 2,
            'year_id' => 2,
            "attributes" => [
                [
                    "subject" => "برند",
                    "value" => "اسپیدی",
                ],
                [
                    "subject" => "مدل",
                    "value" => "Power 10W-40",
                ],
                [
                    "subject" => "حجم",
                    "value" => "4 لیتری",
                ],
            ],
        ]);
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_a_product_can_delete() {
        $response = $this->delete(route('products.delete', ['id' => 1]));
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

}
