<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
use Carbon\Carbon;
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
        $this->withoutExceptionHandling();
        factory(Rental::class, 10)->states('forCreate')->create([
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays(5),
        ]);
        factory(Rental::class, 10)->states('forCreate')->create([
            'start_date' => Carbon::today()->addDay(),
            'end_date' => Carbon::today()->addDays(6),
        ]);
        factory(Rental::class, 10)->states('forCreate')->create([
            'start_date' => Carbon::today()->subDays(10),
            'end_date' => Carbon::today()->subDays(5),
        ]);
        factory(Rental::class, 10)->states('forCreate')->create([
            'start_date' => Carbon::today()->addDays(5),
            'end_date' => Carbon::today()->addDays(10),
        ]);
        factory(Rental::class, 10)->states('forCreate')->create([
            'type' => 'maintenance',
            'start_date' => Carbon::today()->subDays(5),
            'end_date' => Carbon::today()->addDays(10),
        ]);
        factory(Rental::class, 10)->states('forCreate')->create([
            'type' => 'cleaning',
            'start_date' => Carbon::today()->subDays(5),
            'end_date' => Carbon::today()->addDays(10),
        ]);

        $this->json('GET', 'api/dashboard')
        ->assertStatus(200);
    }
}
