<?php

use Illuminate\Database\Seeder;

class SchoolDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_details')->insert([
            'school_name' => 'Demo',
            'school_short_name' => 'Demo',
            'address' => 'Noida',
            'mobile_no' => '8292814411',
            'mobile_no2' => '8877816375',
            'phone_no' => '9122072318',
            'pin_code'=> 110096,
            'city'=> 'Delhi',
            'state'=> 'Delhi',
            'country'=> 'India',
            'country_code'=> 'IN',
            'country_phone_code'=> '+91',
            'currency'=> 'INR',
            'web_site'=> 'www.galaxywebsolution.in',
            'email'=> 'info@galaxywebsolution.in',
            'logo'=> '',
            'water_mark'=> '',	
        ]);
    }
}
