<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RentalTest extends TestCase
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
    public function indexReturnRentals()
    {
        factory(Rental::class, 10)->states('forCreate')->create([
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays(5),
        ]);
        $this->json('GET', 'api/rentals')
            ->assertStatus(200);
    }

    /** @test */
    public function showReturnRental()
    {
        $rental = factory(Rental::class)->states('forCreate')->create();
        $this->json('GET', 'api/rentals/' . $rental->id)
            ->assertStatus(200);
    }

    /** @test */
    public function aRentalCanBeCreated()
    {
        $rental = factory(Rental::class)->states('forMake')->make()->toArray();
        $this->json('POST', 'api/rentals', $rental)
            ->assertStatus(201);
        $rentalDB = Rental::find(1);
        $this->assertDatabaseHas('rentals', [
            'user_id' => $rentalDB->user_id,
            'category_id' => $rentalDB->category_id
        ]);
    }

    /** @test */
    public function aRentalCannotBeCreatedIfCarUnvailable()
    {
        $rental = factory(Rental::class)->states('forCreate')->create();
        $newRental = factory(Rental::class)->states('forMake')->make([
            'start_date' => $rental->start_date,
            'end_date' => $rental->end_date,
            'category_id' => $rental->category_id
        ])->toArray();
        $this->json('POST', 'api/rentals', $newRental)
            ->assertStatus(403);
        $this->assertDatabaseMissing('rentals', [
            'notes' => $newRental['notes'],
        ]);
    }

    /** @test */
    public function aRentalCanBeUpdated()
    {
        $rental = factory(Rental::class)->states('forCreate')->create();
        $this->assertDatabaseHas('rentals', [
            'user_id' => $rental->user_id,
            'category_id' => $rental->category_id
        ]);
        $newRental = factory(Rental::class)->states('forMake')->make()->toArray();
        $this->json('PUT', 'api/rentals/' . $rental->id, $newRental)
            ->assertStatus(201);
        $rentalDB = Rental::find($rental->id);
        $this->assertDatabaseHas('rentals', [
            'user_id' => $rentalDB['user_id'],
            'category_id' => $rentalDB['category_id']
        ]);
        $this->assertDatabaseMissing('rentals', [
            'user_id' => $rental->user_id,
            'category_id' => $rental->category_id
        ]);
    }

    /** @test */
    public function aRentalCanBeDeleted()
    {
        $rental = factory(Rental::class)->states('forCreate')->create();
        $this->json('DELETE', 'api/rentals/' . $rental->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing('rentals', [
            'user_id' => $rental->user_id,
            'category_id' => $rental->category_id
        ]);
    }
}
