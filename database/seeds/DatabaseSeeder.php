<?php

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
        // $this->call(SessionTableSeeder::class);
        $this->call(FeeSettingSeeder::class);
        $this->call(BloodGroupSeeder::class);
        $this->call(EducationSeeder::class);
        $this->call(OccupationSeeder::class);
        $this->call(PaymentModeSeeder::class);

    }
}
