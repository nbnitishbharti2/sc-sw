<?php

use Illuminate\Database\Seeder;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bllod_groups = ['A+','A-','B+','B-','O+','O-','AB+','AB-','Other'];
        foreach ($bllod_groups as $key => $value) {
        	DB::table('blood_groups')->insert([
	            'name' => $value,
	            'created_at'=>date('Y-m-d H:i:s'),
	            'updated_at'=>date('Y-m-d H:i:s'), 
	        ]);  
        }
    }
}
