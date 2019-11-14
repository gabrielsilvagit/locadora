<?php

namespace Tests\Feature;

use App\DropOff;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function show_report()
    {
        $dropoff = factory(DropOff::class)->create();
        $this->json('GET', 'api/reports/'.$dropoff->id)
            ->assertStatus(200);
    }
}
