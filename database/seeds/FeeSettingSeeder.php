<?php

use Illuminate\Database\Seeder;

class FeeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fee_settings')->insert([
            'session_id' => 1,
            'school_fee_frequency' => 1,
            'transport_fee_frequency' => 2,
            'hostel_fee_frequency' => 3,
            'emand_slip_generation_mode' =>'Auto',
            'demand_slip_generation_message' =>'No',
            'demand_slip_reminder_message' =>'No',
            'reminder_date_time'=>date('Y-m-1'),
            'payment_message' =>'No',
            'registration_message' =>'Yes',
            'admission_message' =>'Yes', 
            'registration_fee' =>'Yes',
            'registration_no_auto' =>'Yes',
            'registration_no_start' =>1000,
        ]);
    }
}
 