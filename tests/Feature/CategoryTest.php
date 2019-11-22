<?php

namespace Tests\Feature;

use App\User;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
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
    public function index_return_categories()
    {
        $category = factory(Category::class)->create();
        $this->json('GET', 'api/categories')
            ->assertStatus(200);
    }

    /** @test */
    public function show_return_category()
    {
        $category = factory(Category::class)->create();
        $this->json('GET', 'api/categories/' . $category->id)
            ->assertStatus(200);
    }

    /** @test */
    public function a_category_can_be_created()
    {
        $category = factory(Category::class)->make();
        $form = $this->form($category);
        $this->json('POST', 'api/categories', $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'name' => $category->name
        ]);
    }

    /** @test */
    public function a_category_can_be_updated()
    {
        $category = factory(Category::class)->create();
        $this->assertDatabaseHas('categories', [
            'name' => $category->name
        ]);
        $newCategory = factory(Category::class)->make();
        $form = $this->form($newCategory);
        $response = $this->json('PUT', 'api/categories/' . $category->id, $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'name' => $newCategory->name
        ]);
        $this->assertDatabaseMissing('categories', [
            'name' => $category->name
        ]);
    }

    /** @test */
    public function a_category_can_be_deleted()
    {
        $category = factory(Category::class)->create();
        $this->json('DELETE', 'api/categories/' . $category->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing('categories', [
            'name' => $category->name
        ]);
    }

    private function form($data)
    {
        $form = [];
        $form['name'] = $data->name;
        $form['free_daily_rate'] = $data->free_daily_rate;
        $form['daily_rate'] = $data->daily_rate;
        $form['extra_km_price'] = $data->extra_km_price;

        return $form;
    }
}
