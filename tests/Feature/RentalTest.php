<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RentalTest extends TestCase
{
    use RefreshDatabase;

    // TODO: Rental tests

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
    public function index_return_rentals()
    {
        $rental = factory(Rental::class)->create([
            'type'=>'Aluguel',
        ]);
        $this->json('GET', 'api/rentals')
            ->assertStatus(200);
    }

    /** @test */
    public function show_return_rental()
    {
        $rental = factory(Rental::class)->create();
        $this->json('GET', 'api/rentals/' . $rental->id)
            ->assertStatus(200);
    }

    /** @test */
    public function a_rental_can_be_created()
    {
        $this->withoutExceptionHandling();
        factory(Rental::class, 10)->create([
            'type' => 'Aluguel',
            'category_id'=>1,
        ]);
        $rental = factory(Rental::class)->make([
            'type' => 'Aluguel',
            'category_id'=>1
        ])->toArray();
        $this->json('POST', 'api/rentals', $rental)
            ->assertStatus(201);
        $this->assertDatabaseHas('rentals', [
            'user_id' => $rental->user_id,
            'category_id' => $rental->category_id
        ]);
    }

    /** @test */
    public function a_rental_cannot_be_created_if_car_unvailable()
    {
        $rental = factory(Rental::class)->create();
        $newRental = factory(Rental::class)->make([
            'start_date' => $rental->start_date,
            'end_date' => $rental->end_date,
            'category_id' => $rental->category_id
        ]);

        $form = $this->form($newRental);
        $response = $this->json('POST', 'api/rentals', $form)
            ->assertStatus(400);
        $this->assertDatabaseMissing('rentals', [
            'user_id' => $newRental->user_id,
            'category_id' => $newRental->category_id
        ]);
    }

    /** @test */
    public function a_rental_can_be_updated()
    {
        $rental = factory(Rental::class)->create();
        $this->assertDatabaseHas('rentals', [
            'user_id' => $rental->user_id,
            'category_id' => $rental->category_id
        ]);
        $newRental = factory(Rental::class)->make()->toArray();
        $form = $this->form($newRental);
        $response = $this->json('PUT', 'api/rentals/' . $rental->id, $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('rentals', [
            'user_id' => $newRental->user_id,
            'category_id' => $newRental->category_id
        ]);
        $this->assertDatabaseMissing('rentals', [
            'user_id' => $rental->user_id,
            'category_id' => $rental->category_id
        ]);
    }

    /** @test */
    public function a_rental_can_be_deleted()
    {
        $rental = factory(Rental::class)->create();
        $this->json('DELETE', 'api/rentals/' . $rental->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing('rentals', [
            'user_id' => $rental->user_id,
            'category_id' => $rental->category_id
        ]);
    }
}
