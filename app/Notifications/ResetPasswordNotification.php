<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/forgot/password/reset/'.$this->token.'?email='.$notifiable->email);

        return (new MailMessage)
            ->subject('Recuperação de senha - Sistema SAC')
            ->view('emails.reset-password', [
                'url' => $url,
                'user' => $notifiable
            ]);
    }
}
