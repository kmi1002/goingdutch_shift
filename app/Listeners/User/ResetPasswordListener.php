<?php

namespace App\Listeners\User;

use App\Events\User\ResetPassword;
use App\Notifications\ResetPasswordEmailNotification;

class ResetPasswordListener
{
    /**
     * ResetPasswordListener constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param ResetPassword $event
     */
    public function handle(ResetPassword $event)
    {
        $event->user->notify(new ResetPasswordEmailNotification($event->user->email, $event->token));
    }
}
