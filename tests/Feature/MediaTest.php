<?php

namespace Tests\Feature;

use App\Enums\MediaTypes;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User;
     */
    private $user;
    /**
     * Setup the test environment.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();
//        Artisan::call('db:seed ');

        $this->withoutExceptionHandling();

        $this->user = User::factory()->create([
            'password' => Hash::make('12345678')
        ]);

        Sanctum::actingAs($this->user, ['*']);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_upload_a_media()
    {

        Storage::fake();

        $response = $this->post(route('store-media'), [
            'type' => MediaTypes::AVATAR,
            'media' => UploadedFile::fake()->image('photo2.jpg')
        ]);

        $response->assertStatus(201);

        $filename = json_decode($response->getContent())->filename;

        Storage::disk('public')->assertExists($filename);

    }
}
