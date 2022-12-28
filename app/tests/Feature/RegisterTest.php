<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    public function testRegister()
    {
        // Set up the request data
        $requestData = [
            'name' => 'Test User',
            'email' => 'testuser1@example.com',
            'password' => 'password',
        ];
    
        // Send the request to the endpoint
        $response = $this->json('POST', 'api/register', $requestData);
    
        // Assert that the response has the correct status code
        $response->assertStatus(200);
    
        // Assert that the response has the correct structure
        $response->assertJsonStructure([
            'status',
            'message',
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
    
        // Assert that the user was created successfully
        $responseData = $response->decodeResponseJson();
        $this->assertEquals('success', $responseData['status']);
        $this->assertEquals('User created successfully', $responseData['message']);

        
    }

    public function testRegisterWithNotValidEmail()
    {
        // Set up the request data
        $requestData = [
            'message' => "User not created.",
            'status'=>'failed'
        ];
        // Send the request to the endpoint
        $response = $this->json('POST', 'api/register', $requestData);
    
        // Assert that the response has the correct status code
        $response->assertStatus(500);
    
        // Assert that the response has the correct structure
        $response->assertJsonStructure([
            'status',
            'message'
        ]);
    
        // Assert that the user was created successfully
        $responseData = $response->decodeResponseJson();
        $this->assertEquals("failed", $responseData['status']);
        $this->assertEquals("User not created.", $responseData['message']);
    }
}