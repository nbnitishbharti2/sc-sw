<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->insert([
            'classes_id' => 1,
            'session_id' => 1,
            'section_name' => 'A',
            'section_short' => 'A',
            'status' => 'Active',
            'added_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
