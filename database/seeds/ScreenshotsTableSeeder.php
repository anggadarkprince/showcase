<?php

use Illuminate\Database\Seeder;

class ScreenshotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Screenshot::class, 200)->create();
    }
}
