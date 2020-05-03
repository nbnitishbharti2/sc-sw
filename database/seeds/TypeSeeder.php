<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert(array(
		    array(
		       'name' => 'Single'
		    ),
		    array(
		       'name' => 'Double'
		    ),
		    array(
		       'name' => 'Room'
		    ),
		    array(
		       'name' => 'Dormitory'
		    ),
		));
    }
} 