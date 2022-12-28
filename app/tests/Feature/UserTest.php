<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{

    public function testUpdateEmail()
    {

        // Create a user
        $user = User::factory()->create([
            'email' => 'test-updatemail-test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Set up the request data
        $requestData = [
            'email' => 'new@example.com',
        ];

        // Send the request to the endpoint, authenticated as the user
        $response = $this->actingAs($user)
            ->json('PATCH', '/api/me/email', $requestData);
        // Assert that the response has the correct status code
        $response->assertStatus(200);

        // Assert that the response has the correct structure
        $response->assertJsonStructure([
            'status',
            'message',
        ]);

        // Assert that the email was updated successfully
        $responseData = $response->decodeResponseJson();
        $this->assertEquals('success', $responseData['status']);
        $this->assertEquals('Email updated successfully. Email account must be verified again.', $responseData['message']);

        // Assert that the user's email was updated in the database
        $user = User::find($user->id);
        $this->assertEquals('new@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }
}
