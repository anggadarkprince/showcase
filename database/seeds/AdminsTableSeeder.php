<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Angga Ari Wijaya',
            'username' => 'anggaari',
            'email' => 'me@angga-ari.com',
            'password' => bcrypt('angga1234'),
            'api_token' => str_random(60),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
