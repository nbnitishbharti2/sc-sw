<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sessions')->insert([
            'session' => date("Y").'-'.date("Y", strtotime('+1 year')),
            'added_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
