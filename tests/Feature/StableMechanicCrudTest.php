<?php

namespace Tests\Feature;

use App\Enums\DaysOfTheWeek;
use App\Enums\MechanicTypes;
use App\Enums\VehicleTypes;
use App\Models\City;
use App\Models\Dailywork;
use App\Models\Mechanic;
use App\Models\Province;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Tests\TestCase;

class StableMechanicCrudTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
        $this->withoutExceptionHandling();
        Artisan::call('db:seed ');
//        Artisan::call('db:seed --class=ProvinceSeeder');
//        Artisan::call('db:seed --class=CitySeeder');

        $user = User::factory()->create();
        $mechanic = $user->mechanic()->create([
            'type' => MechanicTypes::STABLE,
            'name' => "test",
            'license' => "109090909090",
            'activated' => true,
            'phone' => "09371801145",
            'count_available' => 10,
        ]);
        $this->user = $user;

        //Mechanic::factory(['user_id' => 1])->create();
//        Artisan::call('db:seed --class=MechanicServiceSeeder');
//        $mechanic   = Mechanic::factory()->count(5)->create();
        Sanctum::actingAs($this->user, ['*']);
    }

    public function test_create_stable_mechanic()
    {
        $user = User::factory()->create();
        $response = $this->post(route('mechanic.stable.store', $user->id), [
            'name' => 'تعمیرگاه اکبری',
            'working_day' => DaysOfTheWeek::ALL,
            'type_vehicle' => VehicleTypes::ALL,
            'working_hour' => ['08:00', '20:00'],
            'license' => '1234567890',
            'activated' => 1,
            'count_available' => rand(1, 15),
            'province_id' => '1',
            'city_id' => '1',
            'detail_address' => 'sea road',
            'phone' => '12345678',
        ]);

        $response->assertStatus(200);
        $this->assertCount(count(DaysOfTheWeek::ALL), Dailywork::all());
    }

    public function test_edit_stable_mechanic()
    {
        $user = $this->user;
        $dailyWorks = [DaysOfTheWeek::SUNDAY, DaysOfTheWeek::MONDAY, DaysOfTheWeek::TUESDAY];
        $response = $this->put(route('mechanic.stable.update', [$user->id, $user->mechanic->id]), [
            'name' => 'تعمیرگاه اصغری',
            'working_day' => $dailyWorks,
            'working_hour' => ['08:00', '20:00'],
            'license' => '9876543210',
            'type_vehicle' => VehicleTypes::CAR,
            'activated' => 1,
            'province_id' => 1,
            'city_id' => 1,
            'count_available' => rand(5, 17),
            'detail_address' => 'sea road',
            'phone' => '12345678',
            'type' => MechanicTypes::STABLE,
            'pelak' => '12345678',
        ]);
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_user_can_delete_stable_mechanic()
    {
        $user = $this->user;
        $mechanic = Mechanic::findOrFail(1);

        foreach (DaysOfTheWeek::ALL as $day) {
            $mechanic->dailyworks()->create([
                'day' => $day,
                'from' => '08:00',
                'to' => '20:00',
            ]);
        }
        $response = $this->delete(route('mechanic.stable.delete', [$user, $mechanic]));
        $response->assertStatus(HTTPResponse::HTTP_OK);

    }

    public function test_show_static_mechanic()
    {
        $user = User::factory()->create();

        $user->mechanic()->create([
            'name' => 'تعمیرگاه اکبری',
            'type' => MechanicTypes::STABLE,
            'type_vehicle' => VehicleTypes::CAR,
            'license' => '1234567890',
            'activated' => 1,
            'count_available' => rand(1, 15),
            'phone' => '12345678',
        ]);

        $mechanic = $user->mechanic;

        $response = $this->get(route('mechanic.stable.show', [$user, $mechanic]));
        $response->assertStatus(HTTPResponse::HTTP_OK);
    }

    public function test_stable_mechanic_list()
    {
        $response = $this->get(route('mechanic.stable.list'));

        $response->assertSuccessful();
    }

}
