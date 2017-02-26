<?php

namespace App\Listeners;

use App\Admin;
use App\Events\PortfolioCreated;
use App\Mail\NewPortfolio;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDiscoveryNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PortfolioCreated $event
     * @return void
     */
    public function handle(PortfolioCreated $event)
    {
        $portfolio = $event->portfolio;
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Log::info("Discover new portfolio {$portfolio->title} to admin {$admin->name}");
            Mail::to($admin)->send(new NewPortfolio($portfolio, $admin));
        }
    }
}
