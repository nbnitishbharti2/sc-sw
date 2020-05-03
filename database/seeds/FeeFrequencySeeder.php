<?php

use Illuminate\Database\Seeder;

class FeeFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $frequencies = ['Monthly','Quarterly','Half Yearly','Yearly'];
        foreach ($frequencies as $key => $value) {
        	DB::table('fee_frequencies')->insert([
	            'name' => $value,
	            'created_at'=>date('Y-m-d H:i:s'),
	            'updated_at'=>date('Y-m-d H:i:s'), 
	        ]);  
        }
    }
}
