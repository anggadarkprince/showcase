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
            'username' => 'admin',
            'email' => 'admin@showcase.dev',
            'password' => bcrypt('admin1234'),
            'api_token' => str_random(60),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('admins')->insert([
            'name' => 'Rio Ferdinand',
            'username' => 'operator',
            'email' => 'operator@showcase.dev',
            'password' => bcrypt('operator1234'),
            'api_token' => str_random(60),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
