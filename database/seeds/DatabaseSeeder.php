<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UserRolesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(PortfoliosTableSeeder::class);
        $this->call(ScreenshotsTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(PortfolioTagsTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
    }
}
