<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
use Tests\TestCase;
use App\Maintenance;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaintenanceTest extends TestCase
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
    public function indexReturnMaintenances()
    {
        $maintenance = factory(Maintenance::class)->make()->toArray();
        $this->json('POST', 'api/maintenances', $maintenance);
        $this->json('GET', 'api/maintenances')
            ->assertStatus(200);
    }

    /** @test */
    public function showReturnMaintenance()
    {
        $maintenance = factory(Maintenance::class)->make()->toArray();
        $this->json('POST', 'api/maintenances', $maintenance);
        $maintenanceDB = Rental::find(1);
        $this->json('GET', 'api/maintenances/' . $maintenanceDB->id)
            ->assertStatus(200);
    }

    /** @test */
    public function aMaintenanceCanBeCreated()
    {
        $maintenance = factory(Maintenance::class)->make()->toArray();
        $this->json('POST', 'api/maintenances', $maintenance)
            ->assertStatus(201);
        $maintenanceDB = Rental::find(1);
        $this->assertDatabaseHas('rentals', [
            'user_id' => $maintenanceDB->user_id,
        ]);
    }

    /** @test */
    public function aMaintenanceCanBeUpdated()
    {
        $maintenance = factory(Maintenance::class)->make()->toArray();
        $this->json('POST', 'api/maintenances', $maintenance)
            ->assertStatus(201);
        $maintenanceDB = Rental::find(1);
        $this->assertDatabaseHas('rentals', [
            'notes' => $maintenanceDB->notes,
        ]);

        $newMaintenance = factory(Maintenance::class)->make()->toArray();
        $this->json('PUT', 'api/maintenances/' . $maintenanceDB->id, $newMaintenance)
        ->assertStatus(201);
        $this->assertDatabaseMissing('rentals', [
            'notes' => $maintenanceDB->notes,
        ]);
        $this->assertDatabaseHas('rentals', [
            'notes' => $newMaintenance['notes'],
        ]);
    }

    /** @test */
    public function aMaintenanceCanBeDeleted()
    {
        $maintenance = factory(Maintenance::class)->make()->toArray();
        $this->json('POST', 'api/maintenances', $maintenance)
            ->assertStatus(201);
        $maintenanceDB = Rental::find(1);
        $this->json('DELETE', 'api/maintenances/' . $maintenanceDB->id)
        ->assertStatus(200);
        $this->assertDatabaseMissing('rentals', [
            'user_id' => $maintenanceDB->user_id,
        ]);
    }
}
