<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = factory(User::class)->create([
            'password' => bcrypt('password')
        ]);
        $credentials['email'] = $user->email;
        $credentials['password'] = 'password';
        $this->json('POST', 'api/login', $credentials)
        ->assertStatus(200);
    }

    /** @test */
    public function a_user_can_be_create()
    {
        $user = factory(User::class)->make()->toArray();
        $this->json('POST', 'api/users', $user)
            ->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'name' => $user['name']
        ]);
    }

    /** @test */
    public function registering_password_after_user_created()
    {
        $user = factory(User::class)->create()->toArray();
        $user['password'] = 'senha';
        $userData = User::find($user['id']);
        $response = $this->json('POST', route('password', $userData->remember_token), $user)
            ->assertStatus(201);
    }

    /** @test */
    public function index_return_users()
    {
        $user = factory(User::class)->create();
        $this->json('GET', 'api/users')
            ->assertStatus(200);
    }

    /** @test */
    public function show_return_user()
    {
        $user = factory(User::class)->create();
        $this->json('GET', 'api/users/' . $user->id)
            ->assertStatus(200);
    }

    /** @test */
    public function a_user_can_be_updated()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('password')
        ]);
        $newUser = factory(User::class)->make()->toArray();
        $newUser['password'] = 'password';
        $response = $this->json('PUT', 'api/users/' . $user->id, $newUser)
            ->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'name' => $newUser['name'],
        ]);
    }

    /** @test */
    public function a_user_can_be_deleted()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', 'api/users/' . $user->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
        ]);
    }
}
