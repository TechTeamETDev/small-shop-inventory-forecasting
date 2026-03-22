<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewAccountNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your New Account')
                    ->greeting("Hello {$this->user->name},")
                    ->line("An account has been created for you.")
                    ->line("Email: {$this->user->email}")
                    ->line("Temporary Password: {$this->password}")
                    ->action('Login', url('/login'))
                    ->line('You will be required to reset your password on first login.');
    }
}