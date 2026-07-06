<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

test('auth refresh returns token, access_token, and refreshToken fields', function () {
    // Create a test user
    $user = User::factory()->create([
        'email' => 'refresh-test-' . uniqid() . '@example.com',
        'password' => Hash::make('test-password'),
    ]);

    // Login to get a valid token
    $loginResponse = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'test-password',
    ]);

    $loginResponse->assertStatus(200);
    $token = $loginResponse->json('access_token');
    expect($token)->toBeString();

    // Call the refresh endpoint with the token
    $refreshResponse = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('/api/auth/refresh');

    // Assert the response is successful
    $refreshResponse->assertStatus(200);

    // Assert all three fields are present and are strings
    $data = $refreshResponse->json();
    expect($data)->toHaveKey('access_token');
    expect($data)->toHaveKey('token');
    expect($data)->toHaveKey('refreshToken');
    expect($data['access_token'])->toBeString();
    expect($data['token'])->toBeString();
    expect($data['refreshToken'])->toBeString();

    // Assert token_type is present
    expect($data)->toHaveKey('token_type');
    expect($data['token_type'])->toBe('bearer');

    // Assert expires_in is present and is a number
    expect($data)->toHaveKey('expires_in');
    expect($data['expires_in'])->toBeInt();
});

test('auth refresh returns a new valid token that can be used for authenticated requests', function () {
    $user = User::factory()->create([
        'email' => 'refresh-valid-test-' . uniqid() . '@example.com',
        'password' => Hash::make('test-password'),
    ]);

    // Login
    $loginResponse = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'test-password',
    ]);
    $token = $loginResponse->json('access_token');

    // Refresh to get a new token
    $refreshResponse = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('/api/auth/refresh');

    $newToken = $refreshResponse->json('token');

    // Use the new token to access a protected endpoint
    $meResponse = $this->withHeaders([
        'Authorization' => 'Bearer ' . $newToken,
    ])->getJson('/api/user');

    $meResponse->assertStatus(200);
    expect($meResponse->json('data.email'))->toBe($user->email);
});

test('auth refresh fails with an invalid token', function () {
    $response = $this->postJson('/api/auth/refresh', [], [
        'Authorization' => 'Bearer invalid-token-12345',
    ]);

    $response->assertStatus(401);
});
