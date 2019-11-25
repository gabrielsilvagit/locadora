<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
use App\Vehicle;
use App\Cleaning;
use Tests\TestCase;
use App\Maintenance;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckOutTest extends TestCase
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
    public function aCheckOutUpdateARental()
    {
        $rental = factory(Rental::class)->states('forCreate')->create();
        $this->assertDatabaseHas('rentals', [
            'plate' => null,
            'current_km'=> null,
            'fuel_level'=> null,
            'start_date'=> $rental->start_date
        ]);
        $vehicle = Vehicle::where('category_id', $rental['category_id'])->first();
        $data = [
            'rental_id' => $rental['id'],
            'plate' => $vehicle->plate,
            'current_km'=> 1000000,
            'fuel_level'=> rand(1, 8),
            'category_id'=>$rental['category_id']
        ];
        $this->json('POST', 'api/checkouts/', $data)
            ->assertStatus(201);
        $updatedRental = Rental::find($rental->id);
        $this->assertDatabaseHas('rentals', [
            'plate' => $vehicle->plate,
            'current_km'=> $updatedRental->current_km,
            'fuel_level'=> $updatedRental->fuel_level,
            'start_date'=> $updatedRental->start_date
        ]);
        $this->assertDatabaseMissing('rentals', [
            'plate' => null,
            'current_km'=> null,
            'fuel_level'=> null,
            'start_date'=> $rental->start_date
        ]);
    }

    /** @test */
    public function aCheckOutUpdateAMaintenance()
    {
        $maintenance = factory(Maintenance::class)->make()->toArray();
        $this->json('POST', 'api/maintenances', $maintenance);
        $maintenanceDB = Rental::find(1);
        $data = [
            'rental_id' => $maintenanceDB->id,
            'plate' => $maintenanceDB->plate
        ];
        $this->json('POST', 'api/checkouts/', $data)
            ->assertStatus(201);
    }

    /** @test */
    public function aCheckOutUpdateACleaning()
    {
        $cleaning = factory(Cleaning::class)->make()->toArray();
        $this->json('POST', 'api/maintenances', $cleaning);
        $cleaningDB = Rental::find(1);
        $data = [
            'rental_id' => $cleaningDB->id,
            'plate' => $cleaningDB->plate
        ];
        $this->json('POST', 'api/checkouts/', $data)
            ->assertStatus(201);
    }
}
