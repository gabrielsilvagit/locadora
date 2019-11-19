<?php

namespace Tests\Feature;

use App\Setting;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_return_settings()
    {
        $setting = factory(Setting::class)->create();
        $this->json('GET', 'api/settings')
            ->assertStatus(200);
    }

    /** @test */
    public function show_return_setting()
    {
        $setting = factory(Setting::class)->create();
        $this->json('GET', 'api/setting/'.$setting->id)
            ->assertStatus(200);
    }

    /** @test */
    public function a_setting_can_be_created()
    {
        $setting = factory(Setting::class)->make();
        $form = $this->form($setting);
        $response = $this->json('POST', 'api/settings', $form)
            ->assertStatus(201);
        $this->assertDatabaseHas("settings", [
            "base_km" => $setting->base_km
        ]);
    }
    /** @test */
    public function a_setting_can_be_updated()
    {
        $setting = factory(Setting::class)->create();
        $this->assertDatabaseHas("settings", [
            "base_km" => $setting->base_km
        ]);
        $newSetting = factory(Setting::class)->make();
        $form = $this->form($newSetting);
        $response = $this->json('PUT', 'api/settings/'.$setting->id, $form)
            ->assertStatus(201);
        $this->assertDatabaseHas("settings", [
            "base_km" => $newSetting->base_km
        ]);
        $this->assertDatabaseMissing("settings", [
            "base_km" => $setting->base_km
        ]);
    }

    /** @test */
    public function a_setting_can_be_deleted()
    {
        $setting = factory(Setting::class)->create();
        $this->json('DELETE', 'api/settings/'.$setting->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing("settings", [
            "base_km" => $setting->base_km
        ]);
    }

    private function form($data)
    {
        $form = [];
        $form['base_km'] = $data->base_km;
        return $form;
    }
}
