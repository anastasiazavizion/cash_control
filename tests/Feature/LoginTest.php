<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\Traits\SetupTrait;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use SetupTrait;

    /**
     * A basic feature test example.
     */
    public function test_login_with_correct_data(): void
    {
        Notification::fake();

        $password = 'password';
        $user = User::factory()->create([
            'password' => $password
        ]);
        $this->assertDatabaseHas(User::class, ['email' => $user->email]);
        $response = $this->postJson(route('login'), ['email'=>$user->email, 'password'=>$password]);
        $response->assertStatus(200);
        $this->assertEquals('Authenticated', $response->json());
        $this->assertAuthenticatedAs($user);

        Notification::assertCount(1);
    }

    /**
     * A basic feature test example.
     */
    public function test_login_with_not_correct_data(): void
    {
        Notification::fake();

        $password = 'password';
        $user = User::factory()->create([
            'password' => $password
        ]);
        $this->assertDatabaseHas(User::class, ['email' => $user->email]);
        $response = $this->postJson(route('login'), ['email'=>$user->email, 'password'=>'notcorrectpassword']);
        $response->assertStatus(403);
        $this->assertEquals('Unauthorized', $response->json());
    }
}
