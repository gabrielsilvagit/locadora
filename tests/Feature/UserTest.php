<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_be_create()
    {
        $user = factory(User::class)->make();
        $form = $this->form($user);
        $this->json('POST', 'api/users', $form)
            ->assertStatus(201);
        $this->assertDatabaseHas("users", [
            "name" => $user->name
        ]);
    }
    /** @test */
    public function registering_password_after_user_created()
    {
        $user = factory(User::class)->create();
        $form['password'] = 'senha';
        $response = $this->json('POST', route('password', $user->remember_token), $form);
    }
    /** @test */
    public function index_return_users()
    {
        $user = factory(User::class)->create();
        $this->json('GET', 'api/users')
            ->assertStatus(200);
    }

    /** @test */
    public function a_user_can_be_updated()
    {
        $user = factory(User::class)->create();
        $this->assertDatabaseHas("users", [
            "name" => $user->name,
        ]);
        $newUser = factory(User::class)->make();
        $form = $this->form($newUser);
        $response = $this->json('PUT', 'api/users/'.$user->id, $form)
            ->assertStatus(201);

        $this->assertDatabaseMissing("users", [
            "name" => $user->name,
        ]);
        $this->assertDatabaseHas("users", [
            "name" => $newUser->name,
        ]);
    }

    /** @test */
    public function a_user_can_be_deleted()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', 'api/users/'.$user->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing("users", [
            "name" => $user->name,
        ]);
    }

    private function form($data)
    {
        $form = [];
        $form['name'] = $data->name;
        $form['email'] = $data->email;
        $form['address'] = $data->address;
        $form['city'] = $data->city;
        $form['state'] = $data->state;
        $form['country'] = $data->country;
        $form['cpf'] = $data->cpf;
        $form['dob'] = $data->dob;
        $form['cnh'] = $data->cnh;
        $form['admin'] = $data->admin;
        return $form;
    }
}
