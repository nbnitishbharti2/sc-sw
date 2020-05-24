<?php

use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fee_types = ['Registration','Admission','Regular'];
        foreach ($fee_types as $key => $value) {
        	DB::table('fee_types')->insert([
	            'name' => $value,
	            'created_at'=>date('Y-m-d H:i:s'),
	            'updated_at'=>date('Y-m-d H:i:s'), 
	        ]);  
        }
    }
}
