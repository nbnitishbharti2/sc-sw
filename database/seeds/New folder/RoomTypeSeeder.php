<?php

use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_types')->insert(array(
		    array(
		       'name' => 'AC'
		    ),
		    array(
		       'name' => 'Non-AC'
		    ),
		));
    }
}
