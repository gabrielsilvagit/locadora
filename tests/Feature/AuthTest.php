<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function user_can_be_loggin_with_correct_credential()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('password')
        ]);
        $form = $this->form($user);
        $form['password'] = 'password';
        $this->json('POST', 'api/login', $form)
            ->assertStatus(200);
    }
    /** @test */
    public function user_cannot_be_loggin_with_incorrect_email()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('password')
        ]);
        $form = $this->form($user);
        $form['email'] = 'incorrect@email.com';
        $form['password'] = 'password';
        $this->json('POST', 'api/login', $form)
            ->assertStatus(400);
    }
    /** @test */
    public function user_cannot_be_loggin_with_incorrect_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('password')
        ]);
        $form = $this->form($user);
        $form['password'] = 'incorrectpassword';
        $this->json('POST', 'api/login', $form)
            ->assertStatus(400);
    }

    private function form($data)
    {
        $form['email'] = $data->email;
        $form['password'] = $data->password;
        return $form;
    }
}
