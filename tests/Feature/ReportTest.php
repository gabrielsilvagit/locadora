<?php

namespace Tests\Feature;

use App\User;
use App\DropOff;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
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
    public function show_report()
    {
        $this->withoutExceptionHandling();
        $dropoff = factory(DropOff::class)->create();
        $this->json('GET', 'api/reports/' . $dropoff->id)
            ->assertStatus(201);
    }
}
