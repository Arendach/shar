<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Notification;

class Telegram extends Notification
{
    use Queueable;
    private $telegram_user_id;
    protected $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(int $telegram_user_id, Order $order)
    {
        $this->telegram_user_id = $telegram_user_id;
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $current_site = explode('/', url()->current());
        $url = "http://skyfire.name/shop/orders/details?id={$this->order->id}";
        return TelegramMessage::create()
            ->to($this->telegram_user_id)
            ->content("Привiт! Нове замовлення!\nПоступило з сайту - {$current_site[2]}\n Сума заказу - {$this->order->sum}");
    }
}
