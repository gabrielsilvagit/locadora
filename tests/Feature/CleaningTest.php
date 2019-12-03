<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
use App\Cleaning;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CleaningTest extends TestCase
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
    public function indexReturnCleanings()
    {
        $cleaning = factory(Cleaning::class)->make()->toArray();
        $this->json('POST', 'api/cleanings', $cleaning);
        $this->json('GET', 'api/cleanings')
            ->assertStatus(200);
    }

    /** @test */
    public function showReturnCleaning()
    {
        $cleaning = factory(Cleaning::class)->make()->toArray();
        $this->json('POST', 'api/cleanings', $cleaning);
        $cleaningDB = Rental::find(1);
        $this->json('GET', 'api/cleanings/' . $cleaningDB->id)
            ->assertStatus(200);
    }

    /** @test */
    public function aCleaningCanBeCreated()
    {
        $cleaning = factory(Cleaning::class)->make()->toArray();
        $this->json('POST', 'api/cleanings', $cleaning)
            ->assertStatus(201);
        $cleaningDB = Rental::find(1);
        $this->assertDatabaseHas('rentals', [
            'notes' => $cleaningDB->notes,
        ]);
    }

    /** @test */
    public function aCleaningCanBeUpdated()
    {
        $cleaning = factory(Cleaning::class)->make()->toArray();
        $this->json('POST', 'api/cleanings', $cleaning)
            ->assertStatus(201);
        $cleaningDB = Rental::find(1);
        $this->assertDatabaseHas('rentals', [
            'notes' => $cleaningDB->notes,
        ]);

        $newMaintenance = factory(Cleaning::class)->make()->toArray();
        $this->json('PUT', 'api/cleanings/' . $cleaningDB->id, $newMaintenance)
        ->assertStatus(201);
        $this->assertDatabaseMissing('rentals', [
            'notes' => $cleaningDB->notes,
        ]);
        $this->assertDatabaseHas('rentals', [
            'notes' => $newMaintenance['notes'],
        ]);
    }

    /** @test */
    public function aCleaningCanBeDeleted()
    {
        $cleaning = factory(Cleaning::class)->make()->toArray();
        $this->json('POST', 'api/cleanings', $cleaning)
            ->assertStatus(201);
        $cleaningDB = Rental::find(1);
        $this->json('DELETE', 'api/cleanings/' . $cleaningDB->id)
        ->assertStatus(200);
        $this->assertDatabaseMissing('rentals', [
            'notes' => $cleaningDB->notes,
        ]);
    }
}
