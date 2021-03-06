<?php

namespace Tests\Feature;

use App\User;
use App\Brand;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandTest extends TestCase
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
    public function brand_can_be_create()
    {
        $brand = factory(Brand::class)->make();
        $form = $this->form($brand);
        $this->json('POST', 'api/brands', $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('brands', [
            'name' => $brand->name
        ]);
    }

    /** @test */
    public function index_return_brands()
    {
        $brand = factory(Brand::class)->create();
        $this->json('GET', 'api/brands')
            ->assertStatus(200);
    }

    /** @test */
    public function show_return_brand()
    {
        $brand = factory(Brand::class)->create();
        $this->json('GET', 'api/brands/' . $brand->id)
            ->assertStatus(200);
    }

    /** @test */
    public function brand_can_be_updated()
    {
        $brand = factory(Brand::class)->create();
        $this->assertDatabaseHas('brands', [
            'name' => $brand->name
        ]);
        $newBrand = factory(Brand::class)->make();
        $form = $this->form($newBrand);
        $this->json('PUT', 'api/brands/' . $brand->id, $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('brands', [
            'name' => $newBrand->name
        ]);
        $this->assertDatabaseMissing('brands', [
            'name' => $brand->name
        ]);
    }

    /** @test */
    public function brand_can_be_deleted()
    {
        $brand = factory(Brand::class)->create();
        $this->assertDatabaseHas('brands', [
            'name' => $brand->name
        ]);
        $this->json('DELETE', 'api/brands/' . $brand->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing('brands', [
            'name' => $brand->name
        ]);
    }

    private function form($data)
    {
        $form = [];
        $form['name'] = $data->name;

        return $form;
    }
}
