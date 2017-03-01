<?php

namespace App\Console\Commands;

use App\LogSender;
use Illuminate\Console\Command;

class SendEmailLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:log 
    {email* : Email of registered admin} 
    {--Q|queue : Whether the job should be queued} 
    {--P|password= : Whether password is required}
    {--N|noconfirm=0 : Whether need to be confirmed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email which contain logs to admin';

    private $sender;

    /**
     * Create a new command instance.
     *
     * @param LogSender $sender
     */
    public function __construct(LogSender $sender)
    {
        parent::__construct();
        $this->sender = $sender;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // array parameters does not have default value
        $allArguments = $this->arguments();
        $allOptions = $this->options();

        $isPassed = false;
        if ($this->option('password') == 'loggersecret') {
            $isPassed = true;
        } else {
            $code = $this->secret('What is the password?');
            if ($code == 'loggersecret') {
                $isPassed = true;
            }
        }

        if ($isPassed) {
            $confirmed = false;
            if ($this->option('noconfirm')) {
                $confirmed = true;
            }

            if ($confirmed) {
                $operator = 'SysAdmin';
                $greeting = 'Hi';
                $footer = 'Have a nice day';
                $this->sender->send($allArguments, $allOptions, $operator, $greeting, $footer);
            } else {
                $operator = $this->ask('What is your name?', 'SysAdmin');
                $greeting = $this->choice('Add Greeting?', ['Hi', 'Good Morning', 'Good Afternoon'], 0);
                $footer = $this->anticipate('Add footer message?', ['Thanks', 'Have a nice day']);
                $this->sender->send($allArguments, $allOptions, $operator, $greeting, $footer);
            }
            $this->info("Log email has been sent by {$operator}");
        } else {
            $this->error("Pass code of logger sender is false.");
        }
    }
}
