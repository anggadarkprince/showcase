<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 31; $i++){
            DB::table('user_roles')->insert([
                'user_id' => $i,
                'role_id' => $i == 1 ? 1 : rand(1, 2)
            ]);
        }
    }
}
