<?php

namespace App\Mail;

use App\Admin;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $operator;
    public $greeting;
    public $footer;

    /**
     * Create a new message instance.
     *
     * @param Admin $admin
     * @param string $operator
     * @param string $greeting
     * @param string $footer
     * @internal param bool $isQueue
     */
    public function __construct(Admin $admin, string $operator, string $greeting, string $footer)
    {
        $this->admin = $admin;
        $this->operator = $operator;
        $this->greeting = $greeting;
        $this->footer = $footer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $timestamp = Carbon::now()->format('d F Y h:m A');
        return $this->view('emails.log')
            ->subject("Logger Showcase.dev at {$timestamp}")
            ->attach(storage_path('logs/laravel.log'), [
                'as' => "log_" . str_replace(' ', '_', strtolower($timestamp)) . ".log",
                'mime' => 'application/text',
            ]);;
    }
}
