<?php

declare(strict_types=1);

namespace ACTC\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class AdminWelcome extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct() {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $token = Password::broker('admin')->createToken($notifiable);

        $signedUrl = URL::temporarySignedRoute(
            'filament.admin.auth.password-reset.reset',
            now()->addMinutes(60),
            ['token' => $token, 'email' => $notifiable->email]
        );

        return (new MailMessage())
            ->subject('Welcome to ACTC')
            ->line('Your account has been created for you.')
            ->action('Set your password', $signedUrl)
            ->line('Thank you!')
        ;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
        ];
    }
}
