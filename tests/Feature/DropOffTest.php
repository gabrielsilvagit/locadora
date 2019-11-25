<?php

namespace Tests\Feature;

use App\User;
use App\DropOff;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DropOffTest extends TestCase
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
    public function indexReturnDropOff()
    {
        factory(DropOff::class)->create();
        $this->json('GET', 'api/dropoffs')
            ->assertStatus(200);
    }

    /** @test */
    public function showReturnDropoff()
    {
        $dropoff = factory(DropOff::class)->create();
        $this->json('GET', 'api/dropoffs/' . $dropoff->id)
            ->assertStatus(200);
    }

    /** @test */
    public function aDropOffCanBeCreated()
    {
        $dropoff = factory(DropOff::class)->make()->toArray();
        $response = $this->json('POST', 'api/dropoffs', $dropoff)
            ->assertStatus(201);
        $this->assertDatabaseHas('drop_offs', [
            'damage_notes' => $dropoff['damage_notes']
        ]);
    }

    /** @test */
    public function aDropOffCanBeUpdated()
    {
        $dropoff = factory(DropOff::class)->create();
        $this->assertDatabaseHas('drop_offs', [
            'damage_notes' => $dropoff->damage_notes
        ]);
        $newDropoff = factory(DropOff::class)->make()->toArray();
        $this->json('PUT', 'api/dropoffs/' . $dropoff->id, $newDropoff)
            ->assertStatus(201);
        $this->assertDatabaseHas('drop_offs', [
            'damage_notes' => $newDropoff['damage_notes']
        ]);
        $this->assertDatabaseMissing('drop_offs', [
            'damage_notes' => $dropoff->damage_notes
        ]);
    }

    /** @test */
    public function aDropOffCanBeDeleted()
    {
        $dropoff = factory(DropOff::class)->create();
        $this->json('DELETE', 'api/dropoffs/' . $dropoff->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing('drop_offs', [
            'damage_notes' => $dropoff->damage_notes
        ]);
    }
}
