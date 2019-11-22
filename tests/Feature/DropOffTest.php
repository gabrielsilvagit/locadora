<?php

namespace Tests\Feature;

use App\User;
use App\DropOff;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DropOffTest extends TestCase
{
    use RefreshDatabase;

    // TODO: dropoffs tests

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
    public function index_return_drop_off()
    {
        $dropoff = factory(DropOff::class)->create();
        $this->json('GET', 'api/dropoffs')
            ->assertStatus(200);
    }

    /** @test */
    public function show_return_dropoff()
    {
        $dropoff = factory(DropOff::class)->create();
        $this->json('GET', 'api/dropoffs/' . $dropoff->id)
            ->assertStatus(200);
    }

    /** @test */
    public function a_drop_off_can_be_created()
    {
        $dropoff = factory(DropOff::class)->make();
        $form = $this->form($dropoff);
        $response = $this->json('POST', 'api/dropoffs', $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('drop_offs', [
            'damage_notes' => $dropoff->damage_notes
        ]);
    }

    /** @test */
    public function a_drop_off_can_be_updated()
    {
        $dropoff = factory(DropOff::class)->create();
        $this->assertDatabaseHas('drop_offs', [
            'damage_notes' => $dropoff->damage_notes
        ]);
        $newFuel = factory(DropOff::class)->make();
        $form = $this->form($newFuel);
        $response = $this->json('PUT', 'api/dropoffs/' . $dropoff->id, $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('drop_offs', [
            'damage_notes' => $newFuel->damage_notes
        ]);
        $this->assertDatabaseMissing('drop_offs', [
            'damage_notes' => $dropoff->damage_notes
        ]);
    }

    /** @test */
    public function a_drop_off_can_be_deleted()
    {
        $dropoff = factory(DropOff::class)->create();
        $this->json('DELETE', 'api/dropoffs/' . $dropoff->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing('drop_offs', [
            'damage_notes' => $dropoff->damage_notes
        ]);
    }

    private function form($data)
    {
        $form = [];
        $form['damage'] = $data->damage;
        $form['damage_notes'] = $data->damage_notes;
        $form['clean'] = $data->clean;
        $form['clean_notes'] = $data->clean_notes;
        $form['fuel_level'] = $data->fuel_level;
        $form['current_km'] = $data->current_km;
        $form['rental_id'] = $data->rental_id;

        return $form;
    }
}
