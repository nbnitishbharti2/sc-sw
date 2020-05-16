<?php

use Illuminate\Database\Seeder;

class FacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('facilities')->insert(array(
		    array(
		       'name' => 'R.O.'
		    ),
		    array(
		       'name' => 'WiFi'
		    ),
		    array(
		       'name' => 'Generator'
		    ),
		    array(
		       'name' => 'T.V.'
		    ),
		));
    }
} 