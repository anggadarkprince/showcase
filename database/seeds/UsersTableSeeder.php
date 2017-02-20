<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Angga Ari Wijaya',
            'username' => 'anggadarkprince',
            'email' => 'anggadarkprince@gmail.com',
            'password' => bcrypt('angga1234'),
            'birthday' => '1992-05-26',
            'location' => 'Gresik, Indonesia',
            'contact' => '0009999887',
            'about' => 'Introvert Engineer',
            'status' => 'activated',
            'api_token' => str_random(60),
            'token' => str_random(50),
            'remember_token' => str_random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        factory(User::class, 30)->create();
    }
}
