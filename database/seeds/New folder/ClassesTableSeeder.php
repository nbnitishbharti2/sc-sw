<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classes')->insert([
            'session_id' => 1,
            'class_name' => 'Prep I',
            'class_short' => 'Prep I',
            'status' => 'Active',
            'added_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
