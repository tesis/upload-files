<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Uploads;
use App\Models\User;

class UploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_cannot_access_uploads(): void
    {
        $response = $this->postJson('/api/upload');

        $response->assertStatus(401);
    }

    public function test_save_image_failure_missing_some_required_data(): void
    {
        $user = User::factory()->create();

        Storage::fake();

        $data = [
            'title' => 'My Image',
            'description' => 'So cute!!',
            'user_id' => $user->id
        ];

        $response = $this->actingAs($user)->postJson('/api/upload', $data);

        $response->assertStatus(422);

        $data = [
            'title' => 'My Image',
            'description' => 'So cute!!',
            'media' => UploadedFile::fake()->image('photo.png'),
        ];

        $response = $this->actingAs($user)->postJson('/api/upload', $data);

        $response->assertStatus(422);

    }

    public function test_save_image_successfully_with_valid_data(): void
    {
        $user = User::factory()->create();

        Storage::fake();

        $data = [
            'title' => 'My Image',
            'description' => 'So cute!!',
            'media' => UploadedFile::fake()->image('photo.png'),
            'user_id' => $user->id
        ];

        $response = $this->actingAs($user)->postJson('/api/upload', $data);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'path' => public_path('photo.png'),
                'title' => 'My Image',
            ]);
    }

    public function test_save_video_successfully_with_valid_data(): void
    {
        $user = User::factory()->create();

        Storage::fake();

        $data = [
            'title' => 'My Video',
            'description' => 'So cute!!',
            'media' => UploadedFile::fake()->create('sample.mp4', '1000', 'mp4'),
            'user_id' => $user->id
        ];

        $response = $this->actingAs($user)->postJson('/api/upload', $data);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'path' => public_path('sample.mp4'),
                'title' => 'My Video',
            ]);
    }
}
