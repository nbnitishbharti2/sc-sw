<?php

use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $educations = ['PhD','Post Graduate','Graduate','Intermediate','Metric','Non Metric'];
        foreach ($educations as $key => $value) {
        	DB::table('education')->insert([
	            'name' => $value,
	            'created_at'=>date('Y-m-d H:i:s'),
	            'updated_at'=>date('Y-m-d H:i:s'), 
	        ]);  
        }
    }
}
