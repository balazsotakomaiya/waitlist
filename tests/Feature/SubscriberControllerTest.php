<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriberControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $email = 'test@email.com';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_join_waitlist()
    {
        $response = $this->post('/api/v1/subscribers', [
            'email' => $this->email,
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'position' => true,
            ]);

        $this->assertDatabaseHas('subscribers', [
            'email' => $this->email,
        ]);
    }

    public function test_that_you_cannot_use_the_same_email_twice()
    {
        $this->postJson('/api/v1/subscribers', [
            'email' => $this->email,
        ]);

        $response = $this->postJson('/api/v1/subscribers', [
            'email' => $this->email,
        ]);

        $response->assertStatus(422);
    }
}
