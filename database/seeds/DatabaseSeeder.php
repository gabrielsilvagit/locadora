<?php

use App\Rental;
use App\Setting;
use App\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Setting::class, 15)->create();
        factory(Vehicle::class, 15)->create();
        factory(Rental::class, 15)->states('forCreate')->create();
    }
}
