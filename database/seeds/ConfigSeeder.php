<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config') -> insert([
            'lat'=> -7.9359853260984465,
            'lon'=> 112.62616865529099,
        ]);
    }
}
