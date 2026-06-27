<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    public function test_login_redirects_correctly()
    {
        $user = User::first();
        
        $response = $this->post('/login-store', [
            'email' => $user->email,
            'password' => '123456', // Assuming this is the password for the first user
        ]);
        
        $response->assertRedirect();
        
        $redirectUrl = $response->headers->get('Location');
        echo "Redirected to: " . $redirectUrl . "\n";
        
        // Now follow the redirect
        $response2 = $this->get($redirectUrl);
        $response2->assertStatus(200);
    }
}
