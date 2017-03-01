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
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
            ->sendOutputTo(storage_path('logs/inspirations.log'))
            ->everyMinute();

        // Run once a minute
        $schedule->command('queue:work')
            ->before(function () {
                // Task is about to start...
            })
            ->after(function () {
                // Task is complete...
            })
            ->withoutOverlapping();
        // the run php artisan schedule:run 1>> /dev/null 2>&1 or setting the crontab

        $schedule->command('email:log all --queue --password=loggersecret --noconfirm=1')
            ->weekdays()
            ->hourly()
            ->timezone('Asia/Jakarta')
            ->between('8:00', '13:00')
            ->withoutOverlapping()
            ->evenInMaintenanceMode()
            ->appendOutputTo(storage_path('logs/email.log'));

        $schedule->exec('echo "Hello World"')
            ->appendOutputTo(storage_path('logs/hello.log'))
            ->withoutOverlapping()
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
