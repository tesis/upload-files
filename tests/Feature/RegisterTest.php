<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
        use RefreshDatabase;

    public function test_registration_fails_missing_required_field()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'My name',
            'email' => 'my-name@test.si',
            'password' => 'secret_8',
        ]);

        $response->assertStatus(422);
    }

    public function test_registration_fails_password_too_short()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'My name',
            'email' => 'my-name@test.si',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertStatus(422);
    }

    public function test_registration_fails_invalid_email()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'My Name',
            'email' => 'my-name',
            'password' => 'secret_8',
            'password_confirmation' => 'secret_8',
        ]);

        $response->assertStatus(422);
    }

    public function test_registration_fails_passwords_not_matching()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'My Name',
            'email' => 'my-name@test.si',
            'password' => 'secret_8',
            'password_confirmation' => 'secret_7',
        ]);

        $response->assertStatus(422);
    }

    public function test_registration_succeeds()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'My Name',
            'email' => 'my-name@test.si',
            'password' => 'secret_8',
            'password_confirmation' => 'secret_8',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
            ]);
    }

}
