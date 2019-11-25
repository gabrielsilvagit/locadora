<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
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
    public function dashboardIndex()
    {
        $rentals = factory(Rental::class)->states('forCreate')->create([
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays(5),
        ]);
        dd($rentals);
        $this->json('GET', 'api/dashboard')
        ->assertStatus(200);
    }
}
