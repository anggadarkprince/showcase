<?php

namespace App\Listeners;

use App\Admin;
use App\Events\PortfolioCreated;
use App\Jobs\SendDiscoveryEmail;
use App\Mail\NewPortfolio;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PortfolioDiscoveryObserver implements ShouldQueue
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
            // do inside job rather than direct action
            dispatch((new SendDiscoveryEmail($portfolio, $admin))
                ->delay(Carbon::now()->addSeconds(15)));
            //Mail::to($admin)->send(new NewPortfolio($portfolio, $admin));
        }
    }
}
