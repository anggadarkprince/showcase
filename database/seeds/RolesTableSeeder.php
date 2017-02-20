<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role' => 'operator',
            'description' => 'Operator Account',
        ]);

        DB::table('roles')->insert([
            'role' => 'admin',
            'description' => 'Web Administrator',
        ]);
    }
}
