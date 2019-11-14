<?php

namespace Tests\Feature;

use App\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_return_vehicles()
    {
        $fuel = factory(Vehicle::class)->create();
        $this->json('GET', 'api/fuels')
            ->assertStatus(200);
    }

    /** @test */
    public function a_vehicle_can_be_created()
    {
        $this->withoutExceptionHandling();
        $vehicle = factory(Vehicle::class)->make();
        $form = $this->form($vehicle);
        $this->json('POST', 'api/vehicles', $form)
            ->assertStatus(201);
        $this->assertDatabaseHas("vehicles", [
            "chassi" => $vehicle->chassi
        ]);
    }

    /** @test */
    public function a_vehicle_can_be_updated()
    {
        $vehicle = factory(Vehicle::class)->create();
        $this->assertDatabaseHas("vehicles", [
            "chassi" => $vehicle->chassi
        ]);
        $newVehicle = factory(Vehicle::class)->make();
        $form = $this->form($newVehicle);
        $response = $this->json('PUT', 'api/vehicles/'.$vehicle->id, $form)
            ->assertStatus(201);
        $this->assertDatabaseHas("vehicles", [
            "chassi" => $newVehicle->chassi
        ]);
        $this->assertDatabaseMissing("fuels", [
            "chassi" => $vehicle->chassi
        ]);
    }

    /** @test */
    public function a_vehicle_can_be_deleted()
    {
        $vehicle = factory(Vehicle::class)->create();
        $this->json('DELETE', 'api/vehicles/'.$vehicle->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing("vehicles", [
            "chassi" => $vehicle->chassi
        ]);
    }

    private function form($data)
    {
        $form = [];
        $form['plate'] = $data->plate;
        $form['chassi'] = $data->chassi;
        $form['carmodel_id'] = $data->carmodel_id;
        $form['fuel_id'] = $data->fuel_id;
        $form['category_id'] = $data->category_id;
        $form['model_year'] = $data->model_year;
        $form['make_year'] = $data->make_year;

        return $form;
    }
}
