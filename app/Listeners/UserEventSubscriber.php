<?php
/**
 * Created by PhpStorm.
 * User: angga
 * Date: 26/02/17
 * Time: 11:58
 */

namespace App\Listeners;


class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event)
    {
        logger($event->user->name . ' ' . 'was logged in');
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event)
    {
        logger($event->user->name . ' ' . 'was logged out');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }
}