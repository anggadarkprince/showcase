<?php

namespace App\Jobs;

use App\Admin;
use App\Mail\NewPortfolio;
use App\Portfolio;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDiscoveryEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $portfolio;
    private $admin;

    /**
     * Create a new job instance.
     *
     * @param Portfolio $portfolio
     * @param Admin $admin
     */
    public function __construct(Portfolio $portfolio, Admin $admin)
    {
        $this->portfolio = $portfolio;
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Request Cycle with Queues Begins");
        Log::info("Discover new portfolio {$this->portfolio->title} to admin {$this->admin->name}");
        Mail::to($this->admin)->send(new NewPortfolio($this->portfolio, $this->admin));
        Log::info("Request Cycle with Queues Ends");
    }
}
