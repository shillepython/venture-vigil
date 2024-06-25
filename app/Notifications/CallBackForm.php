<?php

namespace App\Notifications;

use App\Models\CallBackForm as CallBackFormModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class CallBackForm extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    public function via(CallBackFormModel $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    /**
     * Get the mail representation of the notification.
     */

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            // Optional recipient user id.
            ->to(config('services.telegram-bot-api.chat_id'))
            // Markdown supported.
            ->content("Оставил заявку на сайте!\n")
            ->line("Имя: " . '*' . $notifiable->first_name . '*')
            ->line("Фамилия: " . '*' . $notifiable->last_name. '*')
            ->line("Телефон: " . '`' . $notifiable->phone. '`');

    }
}
