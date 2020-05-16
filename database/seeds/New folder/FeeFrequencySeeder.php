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
        $frequencies = array(
            0 => array(
                'name'  => 'Monthly',
                'value' => 12
            ),
            1 => array(
                'name'  => 'Quarterly',
                'value' => 4
            ),
            2 => array(
                'name'  => 'Half Yearly',
                'value' => 2
            ),
            3 => array(
                'name'  => 'Yearly',
                'value' => 1
            ),
        );
        
        foreach ($frequencies as $key => $value) {
        	DB::table('fee_frequencies')->insert([
	            'name'         => $value['name'],
                'value'        => $value['value'],
	            'created_at'   => date('Y-m-d H:i:s'),
	            'updated_at'   => date('Y-m-d H:i:s'), 
	        ]);  
        }
    }
}
