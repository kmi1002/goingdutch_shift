<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AuthConfirmEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $email;
    public $name;
    public $token;

    /**
     * AuthConfirmEmailNotification constructor.
     * @param $email
     * @param $name
     * @param $token
     */
    public function __construct($email, $name, $token)
    {
        $this->email    = $email;
        $this->name     = $name;
        $this->token    = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject(\Lang::get('auth.email_confirm.title'))
            ->markdown('user.mail.confirm', ['token' => $this->token]);
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
}
