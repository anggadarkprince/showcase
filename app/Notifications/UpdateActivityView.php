<?php

namespace App\Notifications;

use App\Portfolio;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateActivityView extends Notification implements ShouldQueue
{
    use Queueable;

    private $portfolio;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param Portfolio $portfolio
     */
    public function __construct(User $user, Portfolio $portfolio)
    {
        $this->user = $user;
        $this->portfolio = $portfolio;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->portfolio->title,
            'view' => $this->portfolio->view,
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'username' => $this->user->username,
            'title' => $this->portfolio->title,
            'message' => 'read ' . $this->portfolio->title . " and got " . $this->portfolio->view . " views",
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
