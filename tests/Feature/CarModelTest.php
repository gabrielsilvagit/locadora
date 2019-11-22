<?php

namespace Tests\Feature;

use App\User;
use App\CarModel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarModelTest extends TestCase
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
    public function index_return_carmodels()
    {
        $carmodel = factory(CarModel::class)->create();
        $this->json('GET', 'api/carmodels')
            ->assertStatus(200);
    }

    /** @test */
    public function show_return_carmodel()
    {
        $carmodel = factory(CarModel::class)->create();
        $this->json('GET', 'api/carmodels/' . $carmodel->id)
            ->assertStatus(200);
    }

    /** @test */
    public function a_car_model_can_be_created()
    {
        $carmodel = factory(CarModel::class)->make();
        $form = $this->form($carmodel);
        $response = $this->json('POST', 'api/carmodels', $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('car_models', [
            'name' => $carmodel->name
        ]);
    }

    /** @test */
    public function a_car_model_can_be_updated()
    {
        $carmodel = factory(CarModel::class)->create();
        $this->assertDatabaseHas('car_models', [
            'name' => $carmodel->name
        ]);
        $newCarModel = factory(CarModel::class)->make();
        $form = $this->form($newCarModel);
        $response = $this->json('PUT', 'api/carmodels/' . $carmodel->id, $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('car_models', [
            'name' => $newCarModel->name
        ]);
        $this->assertDatabaseMissing('car_models', [
            'name' => $carmodel->name
        ]);
    }

    /** @test */
    public function a_car_model_can_be_deleted()
    {
        $carmodel = factory(CarModel::class)->create();
        $this->json('DELETE', 'api/carmodels/' . $carmodel->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing('car_models', [
            'name' => $carmodel->name
        ]);
    }

    private function form($data)
    {
        $form = [];
        $form['name'] = $data->name;
        $form['brand_id'] = $data->brand_id;

        return $form;
    }
}
