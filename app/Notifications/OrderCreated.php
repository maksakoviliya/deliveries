<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramUpdates;

class OrderCreated extends Notification
{
    use Queueable;

    private $order;

    public function via($notifiable)
    {
        return ["telegram"];
    }

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function toTelegram($notifiable)
    {
        $url = config('app.url') . '/dashboard/orders/' . $this->order->id;
        return TelegramMessage::create()
            // Optional recipient user id.
            ->to(config('services.telegram-bot-api.chat-id'))
            // Markdown supported.
            ->content("Hello there!\nNew order has been created!")

            ->button('View Order', $url);
    }
}
