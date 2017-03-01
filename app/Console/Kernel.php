<?php

namespace App\Console;

use App\Console\Commands\SendEmailLogs;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendEmailLogs::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
            ->appendOutputTo(storage_path('logs/inspirations.log'))
            ->everyMinute();

        // Run once a minute
        $schedule->command('queue:work')->everyMinute();
        // the run php artisan schedule:run 1>> /dev/null 2>&1 or setting the crontab

        $schedule->exec('echo "Hello World"')
            ->appendOutputTo(storage_path('logs/hello.log'))
            ->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
