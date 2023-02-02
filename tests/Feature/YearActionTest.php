<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Year;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Tests\TestCase;

class YearActionTest extends TestCase
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
        $year = Year::create([
            'name' => "2019",
        ]);
    }

    public function test_get_all_year()
    {
        $response = $this->get(route('year.index'));
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_a_new_year_can_store()
    {
        $response = $this->post(route('year.store'), [
            'name' => '2020',
        ]);
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_a_year_can_update()
    {
        $response = $this->patch(route('year.update', ['id' => 1]), [
            'name' => '1994',
        ]);
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_a_year_can_delete()
    {
        $response = $this->delete(route('year.delete', ['id' => 1]));
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

}
