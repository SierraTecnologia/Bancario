<?php

namespace Support\Listeners;

use Bancario\Events\UserRegisteredEmail;
use Bancario\Notifications\NewAccountEmail;
use Illuminate\Support\Facades\Notification;

class UserRegisteredEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param UserRegisteredEmail $event
     */
    public function handle(UserRegisteredEmail $event)
    {
        Notification::send($event->user, new NewAccountEmail($event->password));
    }
}
