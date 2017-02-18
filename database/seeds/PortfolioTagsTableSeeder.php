<?php

use Illuminate\Database\Seeder;

class PortfolioTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PortfolioTag::class, 200)->create();
    }
}
