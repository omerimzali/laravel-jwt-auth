<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    public function testLogin()
    {

        // Create a user
        $user = User::factory()->create([
            'email' => 'testuser-loginaaaa@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        // Set up the request data
        $requestData = [
            'email' => 'testuser-loginaaaa@example.com',
            'password' => 'password',
        ];

        // Send the request to the endpoint
        $response = $this->json('POST', '/api/login', $requestData);


        // Assert that the response has the correct status code

        // Assert that the response has the correct structure
        $response->assertJsonStructure([
            'status',
            'user' => [
                'id',
                'name',
                'email',
            ],
            'authorisation' => [
                'token',
                'type',
            ],
        ]);

        // Assert that the user was authenticated successfully

        $responseData = $response->decodeResponseJson();


        $this->assertEquals('success', $responseData['status']);

        $user->delete();
    }

    public function testLoginWithUnverifiedEmail()
    {
        // Create a user with an unverified email
        $user = User::factory()->create([
            'email' => 'test-notverified@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => null,
        ]);

        // Set up the request data
        $requestData = [
            'email' => 'test-notverified@example.com',
            'password' => 'password',
        ];

        // Send the request to the endpoint
        $response = $this->json('POST', '/api/login', $requestData);

        // Assert that the response has the correct status code
        $response->assertStatus(401);

        // Assert that the response has the correct structure
        $response->assertJsonStructure([
            'status',
            'message',
        ]);

        // Assert that the user was not authenticated
        $responseData = $response->decodeResponseJson();
        $this->assertEquals('error', $responseData['status']);
        $this->assertEquals('Email should verify.', $responseData['message']);
    }

    public function testLoginWithWrongPassword()
    {

        // Set up the request data
        $requestData = [
            'email' => 'test-notverified@example.com',
            'password' => 'wrongpassword',
        ];

        // Send the request to the endpoint
        $response = $this->json('POST', '/api/login', $requestData);

        // Assert that the response has the correct status code
        $response->assertStatus(401);

        // Assert that the response has the correct structure
        $response->assertJsonStructure([
            'status',
            'message',
        ]);



        // Assert that the user was not authenticated
        $responseData = $response->decodeResponseJson();
        $this->assertEquals("error", $responseData['status']);
        $this->assertEquals('Unauthorized', $responseData['message']);
    }


}
