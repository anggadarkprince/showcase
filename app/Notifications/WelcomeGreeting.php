<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeGreeting extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Sandbox.dev')
            ->line('Hi, '.$this->user->name)
            ->line('Welcome to Showcase.dev professional portfolio.')
            ->action('Explore Showcase', route('page.explore'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'name' => $this->user->name,
            'message' => "Welcome to Sandbox.dev",
        ];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('Welcome '.$this->user->name.' to Sandbox.dev');
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $user = $this->user;

        return (new SlackMessage)
            ->success()
            //->from('angga.ari')
            //->to('#showcase')
            //->image(asset('storage/avatars/noavatar.jpg'))
            ->content('New user has been activated (<'.route('account.show', [$user->username]).'|'.$this->user->name.'>)')
            ->attachment(function ($attachment) use ($user) {
                $attachment->title($user->name.'\'s Profile', route('account.show', [$user->username]))
                    ->fields([
                        'Name' => $user->name,
                        'Username' => $user->username,
                        'Email' => $user->email,
                        'Contact' => $user->contact,
                    ]);
            });
    }
}
