<?php

use Illuminate\Database\Seeder;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $months = ['January','February','March','April','May','June','July ','August','September','October','November','December'];
        foreach ($months as $key => $value) {
        	DB::table('months')->insert([
	            'name' => $value,
	            'short_name' => substr($value,0,3),
	            'created_at'=>date('Y-m-d H:i:s'),
	            'updated_at'=>date('Y-m-d H:i:s'), 
	        ]);  
        }
    }
}
