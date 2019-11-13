<?php

namespace Tests\Feature;

use App\Fuel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FuelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_return_fuels()
    {
        $fuel = factory(Fuel::class)->create();
        $this->json('GET', 'api/fuels')
            ->assertStatus(200);
    }
    /** @test */
    public function a_fuel_can_be_created()
    {
        $fuel = factory(Fuel::class)->make();
        $form = $this->form($fuel);
        $response = $this->json('POST', 'api/fuels', $form)
            ->assertStatus(201);
        $this->assertDatabaseHas("fuels", [
            "name" => $fuel->name
        ]);
    }
    /** @test */
    public function a_fuel_can_be_updated()
    {
        $fuel = factory(Fuel::class)->create();
        $this->assertDatabaseHas("fuels", [
            "name" => $fuel->name
        ]);
        $newFuel = factory(Fuel::class)->make();
        $form = $this->form($newFuel);
        $response = $this->json('PUT', 'api/fuels/'.$fuel->id, $form)
            ->assertStatus(201);
        $this->assertDatabaseHas("fuels", [
            "name" => $newFuel->name
        ]);
        $this->assertDatabaseMissing("fuels", [
            "name" => $fuel->name
        ]);
    }

    /** @test */
    public function a_fuel_can_be_deleted()
    {
        $fuel = factory(Fuel::class)->create();
        $this->json('DELETE', 'api/fuels/'.$fuel->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing("fuels", [
            "name" => $fuel->name
        ]);
    }

    private function form($data)
    {
        $form = [];
        $form['name'] = $data->name;
        $form['price'] = $data->price;
        return $form;
    }
}
