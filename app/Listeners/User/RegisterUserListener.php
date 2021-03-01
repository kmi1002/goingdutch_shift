<?php

namespace App\Listeners\User;

use App\Events\User\RegisterUser;
use App\Notifications\AuthConfirmEmailNotification;

class RegisterUserListener
{
    /**
     * RegisterUserListener constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param RegisterUser $event
     */
    public function handle(RegisterUser $event)
    {
        $email  = $event->user->email;
        $name   = $event->user->nick_name;
        $token  = $event->user->activation_code;

        $event->user->notify(new AuthConfirmEmailNotification($email, $name, $token));
    }
}
