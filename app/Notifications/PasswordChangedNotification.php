<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private string $ip,
        private string $agent,
        private string $resetUrl,
    )
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public
    function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public
    function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->markdown('mail.PasswordChanged', [
                'user' => $notifiable,
                'ip' => $this->ip,
                'agent' => $this->agent,
                'resetUrl' => $this->resetUrl,
            ])
            ->subject('Your password has been changed');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public
    function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
