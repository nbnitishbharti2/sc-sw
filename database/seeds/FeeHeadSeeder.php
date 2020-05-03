<?php

use Illuminate\Database\Seeder;

class FeeHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fee_heads = ['School','Transport','Hostal'];
        foreach ($fee_heads as $key => $value) {
        	DB::table('fee_heads')->insert([
	            'name' => $value,
	            'created_at'=>date('Y-m-d H:i:s'),
	            'updated_at'=>date('Y-m-d H:i:s'), 
	        ]);  
        }
    }
}
