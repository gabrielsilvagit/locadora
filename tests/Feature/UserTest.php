<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_be_create()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->make();
        dd($user);
        $this->json('POST', 'api/users', $user)
            ->assertStatus(201);

        $this->assertDatabaseHas("users", [
            "name" => "Gabriel"
        ]);
    }
}
