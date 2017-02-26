<?php

namespace App\Mail;

use App\Admin;
use App\Portfolio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewPortfolio extends Mailable
{
    use Queueable, SerializesModels;

    private $portfolio;
    private $admin;

    public $greeting = "Hi, admin";
    public $level = "success";
    public $actionUrl = '';
    public $actionText = 'Discover';

    /**
     * Create a new message instance.
     *
     * @param Portfolio $portfolio
     * @param Admin $admin
     */
    public function __construct(Portfolio $portfolio, Admin $admin)
    {
        $this->portfolio = $portfolio;
        $this->admin = $admin;
        $this->actionUrl = route('profile.portfolio.show', [
            $portfolio->user->username,
            str_slug($portfolio->title) . '-' . $portfolio->id
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->greeting = "Hi, {$this->admin->name}";
        return $this->view('emails.discover')
            ->subject("Discover new portfolio - {$this->portfolio->title}")
            ->with([
                'portfolio' => $this->portfolio,
                'outroLines' => [
                    "Keep happy and creative",
                    "All question, please contact +829-3636-34"
                ]
            ]);
    }
}
