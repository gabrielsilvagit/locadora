<?php

namespace Tests\Feature;

use App\User;
use App\Setting;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingTest extends TestCase
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
    public function indexReturnSettings()
    {
        $setting = factory(Setting::class)->create();
        $this->json('GET', 'api/settings')
            ->assertStatus(200);
    }

    /** @test */
    public function showReturnSetting()
    {
        $setting = factory(Setting::class)->create();
        $this->json('GET', 'api/settings/' . $setting->id)
            ->assertStatus(200);
    }

    /** @test */
    public function aSettingCanBeCreated()
    {
        $setting = factory(Setting::class)->make();
        $form = $this->form($setting);
        $response = $this->json('POST', 'api/settings', $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('settings', [
            'base_km' => $setting->base_km
        ]);
    }

    /** @test */
    public function aSettingCanBeUpdated()
    {
        $setting = factory(Setting::class)->create();
        $this->assertDatabaseHas('settings', [
            'base_km' => $setting->base_km
        ]);
        $newSetting = factory(Setting::class)->make();
        $form = $this->form($newSetting);
        $response = $this->json('PUT', 'api/settings/' . $setting->id, $form)
            ->assertStatus(201);
        $this->assertDatabaseHas('settings', [
            'base_km' => $newSetting->base_km
        ]);
        $this->assertDatabaseMissing('settings', [
            'base_km' => $setting->base_km
        ]);
    }

    /** @test */
    public function aSettingCanBeDeleted()
    {
        $setting = factory(Setting::class)->create();
        $this->json('DELETE', 'api/settings/' . $setting->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing('settings', [
            'base_km' => $setting->base_km
        ]);
    }

    private function form($data)
    {
        $form = [];
        $form['base_km'] = $data->base_km;
        $form['age_aditional'] = $data->age_aditional;

        return $form;
    }
}
